import cv2
import face_recognition
import numpy as np
import mysql.connector
import json

# Connect to database (update with your DB settings)
conn = mysql.connector.connect(
    host='localhost',
    user='root',
    password='',
    database='your_database_name'
)
cursor = conn.cursor(dictionary=True)

# Load known face encodings from DB
cursor.execute("SELECT email, face_image FROM users WHERE face_image IS NOT NULL")
results = cursor.fetchall()

known_encodings = []
known_emails = []

for row in results:
    email = row['email']
    face_data = np.loads(row['face_image'].encode())  # if using numpy .npy dumps
    known_encodings.append(face_data)
    known_emails.append(email)

# Capture a frame from webcam
video_capture = cv2.VideoCapture(0)

recognized_email = None

while True:
    ret, frame = video_capture.read()
    if not ret:
        break

    # Resize frame for speed
    small_frame = cv2.resize(frame, (0, 0), fx=0.25, fy=0.25)
    rgb_small_frame = small_frame[:, :, ::-1]

    # Face detection
    face_locations = face_recognition.face_locations(rgb_small_frame)
    face_encodings = face_recognition.face_encodings(rgb_small_frame, face_locations)

    for face_encoding in face_encodings:
        matches = face_recognition.compare_faces(known_encodings, face_encoding)
        face_distances = face_recognition.face_distance(known_encodings, face_encoding)

        best_match_index = np.argmin(face_distances)
        if matches[best_match_index]:
            recognized_email = known_emails[best_match_index]

            # Draw rectangle and label
            top, right, bottom, left = face_locations[0]
            top *= 4
            right *= 4
            bottom *= 4
            left *= 4

            cv2.rectangle(frame, (left, top), (right, bottom), (0, 255, 0), 2)
            cv2.putText(frame, recognized_email, (left, top - 10),
                        cv2.FONT_HERSHEY_SIMPLEX, 0.9, (255, 255, 255), 2)

            break

    cv2.imshow('Face Recognition Login', frame)

    if recognized_email or cv2.waitKey(1) & 0xFF == ord('q'):
        break

video_capture.release()
cv2.destroyAllWindows()

if recognized_email:
    result = {"status": "success", "email": recognized_email}
else:
    result = {"status": "failed", "message": "Face not recognized"}

print(json.dumps(result))
