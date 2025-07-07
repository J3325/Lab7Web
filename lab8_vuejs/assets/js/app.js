const { createApp } = Vue;
const apiUrl = 'http://localhost/lab11_ci/ci4/public';

createApp({
  data() {
    return {
      artikel: [],
      kategoriList: [],
      formData: {
        id: null,
        judul: '',
        isi: '',
        status: 0,
        id_kategori: '',
        gambar: ''
      },
      fileGambar: null,
      showForm: false,
      formTitle: 'Tambah Data',
      statusOptions: [
        { text: 'Draft', value: 0 },
        { text: 'Publish', value: 1 }
      ]
    };
  },
  mounted() {
    this.loadData();
    this.loadKategori();
  },
  methods: {
    handleFileUpload(event) {
      this.fileGambar = event.target.files[0];
    },
    loadData() {
      axios.get(apiUrl + '/post')
        .then(res => {
          this.artikel = res.data.artikel;
        })
        .catch(err => console.error('Gagal memuat artikel:', err));
    },
    loadKategori() {
      axios.get(apiUrl + '/post/kategori')
        .then(res => {
          this.kategoriList = res.data.kategori;
        })
        .catch(err => console.error('Gagal memuat kategori:', err));
    },
    tambah() {
      this.showForm = true;
      this.formTitle = 'Tambah Data';
      this.formData = {
        id: null,
        judul: '',
        isi: '',
        status: 0,
        id_kategori: '',
        gambar: ''
      };
      this.fileGambar = null;
    },
    edit(data) {
      this.showForm = true;
      this.formTitle = 'Ubah Data';
      this.formData = {
        id: data.id,
        judul: data.judul,
        isi: data.isi,
        status: data.status,
        id_kategori: data.id_kategori,
        gambar: data.gambar || ''
      };
      this.fileGambar = null;
    },
    hapus(index, id) {
      if (confirm('Yakin menghapus data?')) {
        axios.delete(`${apiUrl}/post/${id}`)
          .then(() => {
            this.loadData();
          })
          .catch(err => console.error('Gagal menghapus:', err));
      }
    },
    saveData() {
      const form = new FormData();
      form.append('judul', this.formData.judul);
      form.append('isi', this.formData.isi);
      form.append('status', this.formData.status);
      form.append('id_kategori', this.formData.id_kategori);

      if (this.fileGambar) {
        form.append('gambar', this.fileGambar);
      } else if (this.formData.gambar) {
        form.append('gambar', this.formData.gambar);
      }

      const config = {
        headers: { 'Content-Type': 'multipart/form-data' }
      };

      let request;

      if (this.formData.id) {
        form.append('_method', 'PUT'); // Spoof method for CI4
        request = axios.post(`${apiUrl}/post/${this.formData.id}`, form, config);
      } else {
        request = axios.post(`${apiUrl}/post`, form, config);
      }

      request
        .then(() => {
          this.loadData();
          this.loadKategori();
          this.showForm = false;
          this.fileGambar = null;
        })
        .catch(err => {
          console.error('Gagal menyimpan data:', err);
        });
    },
    statusText(stat) {
      return stat == 1 ? 'Publish' : 'Draft';
    }
  }
}).mount('#app');