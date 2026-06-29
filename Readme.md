# 🏋️‍♂️ AI Fitness Challenge Application (FitSquad)

An intelligent, AI-powered fitness platform that provides real-time exercise monitoring, posture correction, and personalized nutrition guidance. 

This project bridges the gap between software engineering and artificial intelligence by utilizing computer vision to evaluate human biomechanics during workouts, completely eliminating the need for expensive personal trainers or extra hardware.

## ✨ Core Features
* **Real-Time Pose Estimation:** Utilizes MediaPipe to detect 33 body landmarks (shoulders, elbows, knees, etc.) with high accuracy.
* **Biomechanical Posture Checking:** Computes joint angles in real-time to ensure exercises (like squats and push-ups) are performed with a safe and correct form.
* **Automated Repetition Tracking:** Intelligently tracks movement cycles to count completed reps without manual input.
* **Smart Nutrition Engine:** Calculates user BMI and automatically generates customized dietary recommendations based on fitness goals.

## 🛠️ Tech Stack & Architecture
This system is built using a modern, decoupled microservice architecture:
* **AI Engine:** Python, OpenCV, MediaPipe (Real-time computer vision & joint angle calculations).
* **Backend API:** PHP, MySQL, Microsoft Azure (RESTful API handling user auth, challenge progress, and leaderboards).
* **Frontend Mobile App:** Android / Java (Native mobile interface for live camera feedback and user dashboards).

## 📂 Repository Structure
* `/frontend-android`: Contains the native Android mobile application and UI components.
* `/backend-api`: Contains the PHP backend scripts and database connections.
* `/ai-engine`: Contains the Python computer vision scripts for MediaPipe pose estimation.

---
*Developed as a Final Year Project for Computer Science and Engineering.*