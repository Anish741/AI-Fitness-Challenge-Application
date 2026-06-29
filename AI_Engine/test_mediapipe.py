import mediapipe as mp
try:
    print("Success: Solutions loaded ->", mp.solutions.pose)
except AttributeError:
    print("Error: Still failing to load solutions.")