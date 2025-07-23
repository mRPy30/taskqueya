import face_recognition
import cv2
import mysql.connector
import base64
import pickle
import requests

# Connect to DB
conn = mysql.connector.connect(
    host="localhost",
    user="root",
    password="",  # ← Replace
    database="task_manager"       # ← Replace
)
cursor = conn.cursor(dictionary=True)

# Load all admin face encodings
cursor.execute("SELECT id, name, face_image FROM users WHERE role='admin' AND face_image IS NOT NULL")
admins = cursor.fetchall()

known_encodings = []
known_ids = []

for admin in admins:
    try:
        encoding = pickle.loads(base64.b64decode(admin['face_image']))
        known_encodings.append(encoding)
        known_ids.append(admin['id'])
    except Exception as e:
        print(f"Error decoding face for {admin['name']}: {e}")

# Capture face
video = cv2.VideoCapture(0)
print("Press 's' to scan your face for login")

while True:
    ret, frame = video.read()
    cv2.imshow("Admin Face Login", frame)
    
    key = cv2.waitKey(1)
    if key == ord('s'):
        rgb_frame = cv2.cvtColor(frame, cv2.COLOR_BGR2RGB)
        face_locations = face_recognition.face_locations(rgb_frame)
        if face_locations:
            face_encoding = face_recognition.face_encodings(rgb_frame, face_locations)[0]
            break
        else:
            print("No face detected. Try again.")

video.release()
cv2.destroyAllWindows()

# Compare face
matches = face_recognition.compare_faces(known_encodings, face_encoding, tolerance=0.5)

if True in matches:
    matched_index = matches.index(True)
    admin_id = known_ids[matched_index]
    print("Face matched! Logging in...")

    # Optional: create PHP session by calling a PHP endpoint
    response = requests.post("http://localhost/controllers/FaceLogin.php", data={"admin_id": admin_id})
    if response.status_code == 200:
        print("Logged in via face recognition.")
    else:
        print("Failed to notify PHP session.")
else:
    print("Face not recognized. Try again.")
