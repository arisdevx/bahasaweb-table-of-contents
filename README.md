# Bahasaweb Table of Contents

Plugin WordPress untuk membuat daftar isi otomatis dari heading H2 yang ada di konten artikel.

## Deskripsi

Plugin ini menambahkan Gutenberg block yang secara otomatis menghasilkan daftar isi (Table of Contents) berdasarkan heading H2 yang ada di konten artikel Anda. Block ini mudah digunakan dan menghasilkan HTML yang SEO-friendly.

## Fitur

- ✅ Gutenberg block yang mudah digunakan
- ✅ Otomatis mendeteksi semua H2 headings di artikel
- ✅ Menambahkan ID otomatis ke H2 headings
- ✅ Format HTML yang SEO-friendly
- ✅ Styling yang responsive dan modern
- ✅ Dapat mengubah judul daftar isi
- ✅ Live preview di editor

## Instalasi

1. Upload folder `bahasaweb-table-of-contents` ke direktori `/wp-content/plugins/`
2. Masuk ke direktori plugin:
   ```bash
   cd wp-content/plugins/bahasaweb-table-of-contents
   ```
3. Install dependencies:
   ```bash
   npm install
   ```
4. Build plugin:
   ```bash
   npm run build
   ```
5. Aktifkan plugin melalui menu 'Plugins' di WordPress

## Cara Menggunakan

1. Buat atau edit post/page di WordPress
2. Klik tombol (+) untuk menambah block baru
3. Cari "Table of Contents" atau "Daftar Isi"
4. Tambahkan block ke konten Anda
5. Block akan otomatis mendeteksi semua H2 headings di artikel
6. Anda bisa mengubah judul daftar isi di sidebar settings

## Format HTML yang Dihasilkan

```html
<div class="wp-block-yoast-seo-table-of-contents yoast-table-of-contents">
    <h2>Daftar isi</h2>
    <ul>
        <li><a href="#heading-id" data-level="2">Heading Text</a></li>
        <!-- ... more items ... -->
    </ul>
</div>
```

## Development

### Build untuk Production
```bash
npm run build
```

### Development Mode (watch mode)
```bash
npm start
```

### Linting
```bash
npm run lint:js
npm run lint:css
```

## Requirements

- WordPress 5.8 atau lebih tinggi
- PHP 7.4 atau lebih tinggi
- Node.js 14 atau lebih tinggi (untuk development)

## Changelog

### 1.0.0
- Initial release
- Gutenberg block untuk Table of Contents
- Auto-detect H2 headings
- Responsive styling

## Author

**Aris Munandar**
- Website: [https://bahasaweb.com](https://bahasaweb.com)

## License

GPL v2 or later

## Support

Untuk bug reports atau feature requests, silakan hubungi melalui [https://bahasaweb.com](https://bahasaweb.com)
