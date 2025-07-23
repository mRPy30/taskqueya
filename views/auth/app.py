from flask import Flask, request, jsonify
import speech_recognition as sr
import pymysql

app = Flask(__name__)

# Connect to DB
conn = pymysql.connect(host='localhost', user='root', password='', db='task_manager')
cursor = conn.cursor()

# Store last matched name temporarily (in-memory only)
pending_login = {}

@app.route('/voice-login', methods=['POST'])
def voice_login():
    if 'audio' not in request.files:
        return jsonify({'success': False, 'message': 'No audio received'})

    file = request.files['audio']
    recognizer = sr.Recognizer()
    try:
        with sr.AudioFile(file) as source:
            audio = recognizer.record(source)
            text = recognizer.recognize_google(audio).lower()
            print("Heard:", text)

            # Try to match name from DB (admin only)
            cursor.execute("SELECT name FROM users WHERE role='admin'")
            admins = cursor.fetchall()
            for (name,) in admins:
                if name.lower() in text:
                    pending_login['name'] = name
                    return jsonify({
                        'success': True,
                        'step': 'confirm',
                        'message': f"Hello {name}, say 'yes' to confirm login.",
                        'name': name
                    })
            return jsonify({'success': False, 'message': 'No matching admin found'})
    except Exception as e:
        print("Error:", e)
        return jsonify({'success': False, 'message': 'Could not understand audio'})

@app.route('/voice-confirm', methods=['POST'])
def voice_confirm():
    if 'audio' not in request.files:
        return jsonify({'success': False, 'message': 'No audio received'})

    file = request.files['audio']
    recognizer = sr.Recognizer()
    try:
        with sr.AudioFile(file) as source:
            audio = recognizer.record(source)
            text = recognizer.recognize_google(audio).lower()
            print("Confirm Heard:", text)

            if ("yes" in text or "confirm" in text) and 'name' in pending_login:
                name = pending_login.pop('name')
                return jsonify({'success': True, 'message': f"Welcome, {name}", 'name': name})
            else:
                return jsonify({'success': False, 'message': 'Confirmation denied'})
    except Exception as e:
        print("Error:", e)
        return jsonify({'success': False, 'message': 'Could not understand confirmation'})
        

if __name__ == '__main__':
    app.run(debug=True)
