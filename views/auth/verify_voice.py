import speech_recognition as sr
import os
import json
import numpy as np
import librosa
from sklearn.metrics.pairwise import cosine_similarity

def extract_features(file_path):
    y, sr_ = librosa.load(file_path, sr=None)
    mfcc = librosa.feature.mfcc(y=y, sr=sr_)
    return np.mean(mfcc, axis=1).reshape(1, -1)

recognizer = sr.Recognizer()

try:
    with sr.Microphone() as source:
        print("[INFO] Please say: 'Hi I'm Vier'")
        audio = recognizer.listen(source, timeout=5)

    # Save new recording
    temp_path = "temp_login_voice.wav"
    with open(temp_path, "wb") as f:
        f.write(audio.get_wav_data())

    # Path to stored admin voice
    registered_path = os.path.join("voice_profiles", "admin@example.com.wav")

    if not os.path.exists(registered_path):
        print(json.dumps({"status": "fail", "message": "Registered voice not found"}))
        exit()

    # Extract features
    input_feat = extract_features(temp_path)
    stored_feat = extract_features(registered_path)

    # Compare similarity
    similarity = cosine_similarity(input_feat, stored_feat)[0][0]
    
    if similarity > 0.9:
        print(json.dumps({"status": "success", "email": "admin@example.com"}))
    else:
        print(json.dumps({"status": "fail", "message": "Voice not recognized"}))

except Exception as e:
    print(json.dumps({"status": "fail", "message": str(e)}))
