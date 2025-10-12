import axios from "axios";
import DataTable from 'datatables.net-dt';

document.addEventListener("DOMContentLoaded", () => {
  const API_URL = import.meta.env.VITE_API_PRICELIST; // Ganti dengan URL API Anda
  const table = document.querySelector("#pricelist-table");

  const fetchData = async () => {
    try {
      // Menampilkan loading indicator
      const loadingRow = `
        <tr>
          <td colspan="4" class="text-center p-10">Loading...</td>
        </tr>
      `;
      table.querySelector("tbody").innerHTML = loadingRow;

      // Fetch data dari API
      const response = await axios.get(API_URL);
      const data = response.data;

      // Hapus data lama di tabel
      const tableBody = table.querySelector("tbody");
      tableBody.innerHTML = "";

      // Loop data dan masukkan ke tabel
      data.forEach((item) => {
        const row = `
          <tr>
            <td class="py-2">${item.ukuran_baju}</td>
            <td class="py-2">${item.ukuran_logo}</td>
            <td class="py-2">${item.jenis_sablon}</td>
            <td class="py-2">Rp${item.harga.toLocaleString()}</td>
          </tr>
        `;
        tableBody.innerHTML += row;
      });

      // Inisialisasi DataTables
      new DataTable(table, {
        paging: true,
        searching: true,
        info: true,
        pageLength: 10, // Jumlah baris per halaman
      });

    } catch (error) {
      console.error("Error fetching data:", error);
      table.querySelector("tbody").innerHTML = `
        <tr>
          <td colspan="4" class="text-center">Failed to load data.</td>
        </tr>
      `;
    }
  };

  // Panggil fungsi fetchData saat halaman selesai dimuat
  fetchData();
});
