import face_recognition
import cv2
import mysql.connector
import base64
import pickle

# === Connect to MySQL ===
conn = mysql.connector.connect(
    host="localhost",
    user="root",
    password="",  # ← Replace
    database="task_manager"       # ← Replace
)
cursor = conn.cursor()

# === Start the webcam and capture face ===
video = cv2.VideoCapture(0)  # 0 = default webcam
print("[INFO] Press 's' to scan and register face...")

face_encoding = None
while True:
    ret, frame = video.read()
    cv2.imshow("Register Admin Face", frame)

    key = cv2.waitKey(1)
    if key == ord('s'):
        # Convert frame to RGB for face_recognition
        rgb_frame = cv2.cvtColor(frame, cv2.COLOR_BGR2RGB)
        face_locations = face_recognition.face_locations(rgb_frame)

        if face_locations:
            # Encode the first detected face
            face_encoding = face_recognition.face_encodings(rgb_frame, face_locations)[0]
            print("[SUCCESS] Face captured.")
            break
        else:
            print("[ERROR] No face detected. Try again...")

video.release()
cv2.destroyAllWindows()

# === If no encoding was captured
if face_encoding is None:
    print("[ERROR] Face encoding failed. Exiting.")
    exit()

# === Ask which admin this face belongs to
admin_email = input("Enter admin email: ")

# === Serialize and encode face data for DB
face_data = pickle.dumps(face_encoding)
face_base64 = base64.b64encode(face_data).decode('utf-8')

# === Update user row in DB
query = "UPDATE users SET face_image = %s WHERE email = %s AND role = 'admin'"
cursor.execute(query, (face_base64, admin_email))
conn.commit()

# === Check result
if cursor.rowcount > 0:
    print("[✅] Face registered successfully for:", admin_email)
else:
    print("[❌] Failed: Email not found or not an admin.")

cursor.close()
conn.close()
