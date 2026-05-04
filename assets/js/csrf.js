// csrf.js (opsional, hanya jika ingin ambil token via fetch)
export async function getCsrfToken() {
    const res = await fetch('backend/csrf.php');
    const data = await res.text();
    return data;
}