import json
import pandas as pd
from sklearn.tree import DecisionTreeClassifier
from sklearn.metrics import accuracy_score
from sklearn.preprocessing import LabelEncoder
from datetime import datetime
import joblib
import os


def convert_lama_bekerja_to_months(value):
    """Konversi '2 tahun 3 bulan' → bulan total."""
    try:
        value = value.lower()
        tahun = bulan = 0

        for v in value.split():
            if "tahun" in value:
                tahun = int(value.split()[0])
            if "bulan" in value:
                bulan = int(value.split()[-2])

        return tahun * 12 + bulan

    except:
        return 0


def proses_training():
    try:
        # === LOAD DATA JSON ===
        BASE_DIR = os.path.dirname(os.path.abspath(__file__))
        DATA_PATH = os.path.join(BASE_DIR, "../storage/app/training/data.json")
        if not os.path.exists(DATA_PATH):
            return {"success": False, "message": "Data training belum tersedia."}

        data = json.load(open(DATA_PATH))
        df = pd.DataFrame(data)

        # ================= PREPROCESSING (SAMA DG PHP) =================
        df["lama_bekerja"] = df["lama_bekerja"].apply(convert_lama_bekerja_to_months)
        df["lama_bekerja"] = pd.to_numeric(df["lama_bekerja"], errors="coerce").fillna(0)

        df["prev_score"] = pd.to_numeric(
            df["hasil_penilaian_kinerja_sebelumnya"], errors="coerce"
        ).fillna(0)

        df["prod_score"] = df["produktivitas_kerja"].apply(
            lambda x: 100 if str(x).upper() == "TERCAPAI" else 0
        )
        df["attendance"] = (pd.to_numeric(df["kehadiran"], errors="coerce") / 26 * 100).clip(0, 100)

        df["composite_score"] = (
            df["prev_score"] * 0.5 +
            df["prod_score"] * 0.3 +
            df["attendance"] * 0.2
        )

        df["label_kinerja"] = df["composite_score"].apply(
            lambda x: "Baik" if x >= 80 else ("Cukup" if x >= 60 else "Kurang")
        )

        # ================= TRAIN MODEL =================

        # Encode kategori
        label_enc = LabelEncoder()
        df["prod_encoded"] = label_enc.fit_transform(df["produktivitas_kerja"].astype(str))

        X = df[["lama_bekerja", "kehadiran", "prod_encoded"]]
        y = df["label_kinerja"]

        model = DecisionTreeClassifier(criterion="entropy")  # Mendekati C4.5
        model.fit(X, y)

        # Save model sebagai JSON/pickle
        os.makedirs("training", exist_ok=True)
        joblib.dump(model, "training/model.pkl")
        joblib.dump(label_enc, "training/encoder.pkl")

        # ================= PREDIKSI ULANG & UJI AKURASI =================
        pred = model.predict(X)
        benar = (pred == y).sum()
        total = len(df)
        akurasi = round((benar / total) * 100, 2)

        accuracyData = {
            "accuracy": akurasi,
            "total_data": total,
            "benar": int(benar),
            "tanggal": datetime.now().strftime("%Y-%m-%d %H:%M:%S")
        }

        open("training/accuracy.json", "w").write(json.dumps(accuracyData, indent=4))

        return {
            "success": True,
            "message": "Training Decision Tree Python berhasil!",
            "accuracy": accuracyData
        }

    except Exception as e:
        return {"success": False, "message": f"Error saat training: {str(e)}"}


# Untuk dijalankan langsung
if __name__ == "__main__":
    result = proses_training()

    if "accuracy" in result and "accuracy" in result["accuracy"]:
        result["accuracy"]["accuracy"] = float(result["accuracy"]["accuracy"])

    print(json.dumps(result))