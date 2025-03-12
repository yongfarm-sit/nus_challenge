import numpy as np
import pandas as pd
from sklearn.ensemble import IsolationForest
from sklearn.preprocessing import MinMaxScaler

# Load dataset
file_path = "anomaly_detection_data.csv"  # Update with your actual file path
df = pd.read_csv(file_path)

# Selecting features
features = ['Transaction_Amount', 'Payment_Method', 'Location_Risk', 'Account_Age']
X = df[features].copy()  # Ensure it's a new DataFrame, avoiding warnings

# Normalize Transaction Amount
scaler = MinMaxScaler()
X[features] = scaler.fit_transform(X)  # Apply transformation to all features

# Train Isolation Forest
model = IsolationForest(n_estimators=100, contamination=0.1, random_state=42)
df["Anomaly_Score"] = model.fit_predict(X)

# Map anomalies
df["Anomaly"] = df["Anomaly_Score"].apply(lambda x: "Unusual" if x == -1 else "Normal")

# Display unusual transactions
anomalies = df[df["Anomaly"] == "Unusual"]
print(f"Detected {len(anomalies)} unusual transactions:")
print(anomalies[['Transaction_ID', 'Transaction_Amount', 'Anomaly']])

# Function to check new transactions
def check_transaction(amount, payment_method, location_risk, account_age):
    # Normalize amount using the same scaler
    new_data = pd.DataFrame([[amount, payment_method, location_risk, account_age]], 
                            columns=features)

    new_data[features] = scaler.transform(new_data)  # Ensure proper scaling
    
    anomaly_score = model.predict(new_data)
    return "Unusual Transaction" if anomaly_score[0] == -1 else "Normal Transaction"

# Example check
result = check_transaction(8000, 2, 3, 1)  # $8000, Wire Transfer, High-Risk Location, 1-Year Old Account
print(result)
