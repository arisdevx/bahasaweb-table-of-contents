# Bahasaweb Table of Contents

A WordPress plugin to automatically generate a table of contents from H2 headings in your article content.

## Description

This plugin adds a Gutenberg block that automatically generates a Table of Contents based on H2 headings in your article content. The block is easy to use and produces SEO-friendly HTML.

## Features

- ✅ Easy-to-use Gutenberg block
- ✅ Automatically detects all H2 headings in the article
- ✅ Automatically adds IDs to H2 headings
- ✅ SEO-friendly HTML format
- ✅ Responsive and modern styling
- ✅ Customizable table of contents title
- ✅ Live preview in the editor

## Installation

1. Upload the `bahasaweb-table-of-contents` folder to the `/wp-content/plugins/` directory
2. Navigate to the plugin directory:
   ```bash
   cd wp-content/plugins/bahasaweb-table-of-contents
   ```
3. Install dependencies:
   ```bash
   npm install
   ```
4. Build the plugin:
   ```bash
   npm run build
   ```
5. Activate the plugin through the 'Plugins' menu in WordPress

## How to Use

1. Create or edit a post/page in WordPress
2. Click the (+) button to add a new block
3. Search for "Table of Contents"
4. Add the block to your content
5. The block will automatically detect all H2 headings in the article
6. You can customize the table of contents title in the sidebar settings

## Generated HTML Format

```html
<div class="bahasaweb-toc">
    <h2>Table of Contents</h2>
    <ul>
        <li><a href="#heading-id" data-level="2">Heading Text</a></li>
        <!-- ... more items ... -->
    </ul>
</div>
```

## Development

### Build for Production
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

- WordPress 5.8 or higher
- PHP 7.4 or higher
- Node.js 14 or higher (for development)

## Changelog

### 1.0.0
- Initial release
- Gutenberg block for Table of Contents
- Auto-detect H2 headings
- Responsive styling

## Author

**Aris Munandar**
- Website: [https://bahasaweb.com](https://bahasaweb.com)

## License

GPL v2 or later

## Support

For bug reports or feature requests, please contact via [https://bahasaweb.com](https://bahasaweb.com)
