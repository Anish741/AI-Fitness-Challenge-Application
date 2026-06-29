import cv2
import mediapipe as mp
import os

# DEBUG: Print the location of the mediapipe library
print("MediaPipe location:", mp.__file__)

# 1. Initialize MediaPipe Pose and Drawing utilities
mp_pose = mp.solutions.pose
mp_drawing = mp.solutions.drawing_utils

# 2. Setup the Pose model
pose = mp_pose.Pose(min_detection_confidence=0.5, min_tracking_confidence=0.5)

# 3. Capture video from your webcam
cap = cv2.VideoCapture(0)

print("Starting Fitness AI Tracker... Press 'q' to exit.")

while cap.isOpened():
    success, frame = cap.read()
    if not success:
        break

    # 4. Convert the BGR image to RGB for processing
    image = cv2.cvtColor(frame, cv2.COLOR_BGR2RGB)
    
    # 5. Process the image and detect pose landmarks
    results = pose.process(image)

    # 6. Draw the pose landmarks on the original frame
    if results.pose_landmarks:
        mp_drawing.draw_landmarks(frame, results.pose_landmarks, mp_pose.POSE_CONNECTIONS)

    # 7. Display the result
    cv2.imshow('Fitness AI Tracker', frame)

    if cv2.waitKey(1) & 0xFF == ord('q'):
        break

cap.release()
cv2.destroyAllWindows()