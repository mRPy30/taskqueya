import speech_recognition as sr
import os

def record_voice(email):
    recognizer = sr.Recognizer()
    with sr.Microphone() as source:
        print("Please say: Hi I'm Vier")
        audio = recognizer.listen(source)

    folder = "voice_profiles"
    os.makedirs(folder, exist_ok=True)
    file_path = os.path.join(folder, f"{email}.wav")
    with open(file_path, "wb") as f:
        f.write(audio.get_wav_data())
    print(f"Voice registered for {email}")

record_voice("admin@example.com")  # change email accordingly
