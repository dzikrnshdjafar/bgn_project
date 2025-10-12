import axios from "axios";
// URL API (sesuaikan dengan URL API Anda)
const apiUrl = import.meta.env.VITE_JSON_DUMMY;

// Seleksi elemen container fitur
const featureContainer = document.getElementById("feature-container");

// Fungsi untuk fetch data menggunakan Axios
async function fetchFeaturesWithAxios() {
  try {
    // Fetch data dari API menggunakan Axios
    const response = await axios.get(apiUrl);

    // Render data ke dalam HTML
    renderFeatures(response.data);
  } catch (error) {
    console.error("Error fetching features:", error);
    featureContainer.innerHTML = `<p class="text-red">Failed to load features. Please try again later.</p>`;
  }
}

// Fungsi untuk render data ke HTML
function renderFeatures(features) {
  // Batasi jumlah data (opsional, misalnya hanya 3 item pertama)
  const limitedFeatures = features.slice(0, 15);

  // Loop data dan buat elemen HTML untuk setiap fitur
  featureContainer.innerHTML = limitedFeatures
    .map(
      (feature) => `
      <div class="bg-primary p-6 rounded-lg shadow-md">
        <h4 class="text-xl font-bold text-secondary">${feature.title}</h4>
        <p class="mt-2 text-slate">${feature.body}</p>
      </div>
    `
    )
    .join("");
}

// Panggil fungsi fetchFeatures
fetchFeaturesWithAxios();
