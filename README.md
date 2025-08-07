# Casino Theme - Glass Morphism WordPress Theme

A modern, responsive WordPress theme designed specifically for casino reviews and gaming websites. Built with Bootstrap 5 and featuring stunning Glass Morphism design effects.

## 🎰 Features

### Design & UI
- **Glass Morphism Design** - Modern glass-like effects with backdrop blur
- **Responsive Layout** - Fully responsive design that works on all devices
- **Bootstrap 5 Integration** - Built with the latest Bootstrap framework
- **Custom Post Types** - Casino and Game post types with custom fields
- **Advanced Rating System** - Star-based rating system for casinos and games
- **Interactive Tables** - Dynamic casino comparison tables with AJAX loading

### Functionality
- **Custom Widgets** - Casino sidebar widget with tabs
- **Shortcodes** - Casino tables and search functionality
- **SEO Optimized** - Structured data and meta tags
- **Performance Optimized** - Lazy loading and optimized queries
- **Translation Ready** - Full internationalization support

### Custom Post Types
- **Casinos** - Complete casino review system with ratings, features, and meta data
- **Games** - Game reviews with provider information and linked casinos

## 🚀 Installation

### Requirements
- WordPress 5.0 or higher
- PHP 7.4 or higher
- MySQL 5.6 or higher

### Installation Steps

1. **Download the theme**
   ```bash
   git clone https://github.com/roltex/casino-theme.git
   ```

2. **Upload to WordPress**
   - Copy the `casino-theme` folder to `/wp-content/themes/`
   - Or zip the folder and upload via WordPress admin

3. **Activate the theme**
   - Go to Appearance > Themes in WordPress admin
   - Activate "Casino Theme - Glass Morphism"

4. **Configure settings**
   - Go to Casino Settings in the admin menu
   - Configure logo, analytics, and performance settings

## 📁 File Structure

```
casino-theme/
├── assets/                 # CSS, JS, and other assets
│   ├── css/               # Stylesheets
│   └── js/                # JavaScript files
├── inc/                   # PHP includes
│   ├── admin-settings.php # Admin settings page
│   ├── custom-fields.php  # Custom meta boxes
│   ├── custom-post-types.php # Post type definitions
│   ├── helpers.php        # Helper functions
│   ├── shortcodes.php     # Shortcode definitions
│   ├── sidebar-widget.php # Custom widgets
│   ├── template-functions.php # Template functions
│   └── theme-settings.php # Theme settings
├── languages/             # Translation files
├── template-parts/        # Template parts
│   ├── casino-card.php    # Casino card template
│   ├── game-card.php      # Game card template
│   └── ...                # Other template parts
├── 404.php               # 404 error page
├── archive.php           # Archive template
├── footer.php            # Footer template
├── functions.php         # Main functions file
├── header.php            # Header template
├── index.php             # Main template
├── page.php              # Page template
├── search.php            # Search template
├── single-casino.php     # Single casino template
├── single-game.php       # Single game template
└── style.css             # Main stylesheet
```

## 🎨 Customization

### Colors and Variables
The theme uses CSS custom properties for easy customization:

```css
:root {
    --bs-gradient-start: #0f172a;
    --bs-gradient-middle: #581c87;
    --bs-gradient-end: #0f172a;
    --bs-primary: #3b82f6;
    --bs-success: #10b981;
    --bs-danger: #ef4444;
    --bs-warning: #f59e0b;
}
```

### Custom CSS
Add custom CSS through the WordPress admin:
1. Go to Casino Settings > Custom CSS
2. Add your custom styles
3. Save changes

## 🔧 Development

### Local Development Setup

1. **Clone the repository**
   ```bash
   git clone https://github.com/roltex/casino-theme.git
   cd casino-theme
   ```

2. **Set up local WordPress**
   - Install WordPress locally (XAMPP, MAMP, or similar)
   - Copy theme to `/wp-content/themes/`

3. **Development workflow**
   - Make changes to theme files
   - Test in local WordPress installation
   - Commit changes to Git

### Building for Production

1. **Optimize assets**
   - Minify CSS and JS files
   - Optimize images
   - Remove development files

2. **Create release**
   ```bash
   git tag -a v1.0.0 -m "Release version 1.0.0"
   git push origin v1.0.0
   ```

## 📝 Usage

### Creating Casino Reviews

1. **Add new casino**
   - Go to Casinos > Add New
   - Fill in casino details (name, description, logo)
   - Set ratings and features
   - Add official site URL and contact information

2. **Configure features**
   - Loyalty Program
   - Live Casino
   - Mobile Casino
   - Year Established

### Creating Game Reviews

1. **Add new game**
   - Go to Games > Add New
   - Fill in game details
   - Set game type and provider
   - Link to related casinos

### Using Shortcodes

#### Casino Table Shortcode

The `casinos_table` shortcode displays a table of casinos with various customization options.

**Basic Usage:**
```
[casinos_table]
```

**Full Syntax:**
```
[casinos_table title="Custom Title" template="1" second_col="loyalty" limit="10"]
```

**Available Parameters:**

| Parameter | Type | Default | Options | Description |
|-----------|------|---------|---------|-------------|
| `title` | string | "Best Casino" | Any text | Custom title for the table |
| `template` | string | "1" | "1", "2" | Table template style |
| `second_col` | string | "loyalty" | See table below | Content for the second column |
| `limit` | integer | 10 | 1-50 | Number of casinos to display |

**Second Column Options:**

| Option | Description | Template Support | Output Format |
|--------|-------------|------------------|---------------|
| `loyalty` | Shows loyalty program status | 1, 2 | YES/NO badges |
| `live_casino` | Shows live casino availability | 1, 2 | YES/NO badges |
| `mobile_casino` | Shows mobile casino availability | 1, 2 | YES/NO badges |
| `year_established` | Shows year of establishment | 2 only | "Est. YYYY" |
| `contact_email` | Shows contact email address | 2 only | Clickable email link |
| `games` | Shows linked games list | 2 only | List of game links |

**Template Variations:**

**Template 1** - Static table with fixed second column:
```
[casinos_table template="1" second_col="loyalty"]
[casinos_table template="1" second_col="live_casino"]
[casinos_table template="1" second_col="mobile_casino"]
```

**Template 2** - Dynamic table with interactive column selection:
```
[casinos_table template="2" second_col="loyalty"]
[casinos_table template="2" second_col="live_casino"]
[casinos_table template="2" second_col="mobile_casino"]
[casinos_table template="2" second_col="year_established"]
[casinos_table template="2" second_col="contact_email"]
[casinos_table template="2" second_col="games"]
```

**Usage Examples:**

```php
// Basic casino table with loyalty program column
[casinos_table]

// Custom title with live casino column
[casinos_table title="Top Live Casinos" second_col="live_casino"]

// Template 2 with mobile casino column, limit 5
[casinos_table template="2" second_col="mobile_casino" limit="5"]

// Template 1 with custom title and mobile casino
[casinos_table title="Mobile-Friendly Casinos" template="1" second_col="mobile_casino" limit="15"]

// Template 2 with year established information
[casinos_table template="2" second_col="year_established" title="Casino History"]

// Template 2 with contact email information
[casinos_table template="2" second_col="contact_email" title="Casino Contact Info"]

// Template 2 with games count
[casinos_table template="2" second_col="games" title="Casino Games Library"]

// Template 2 with loyalty program (default)
[casinos_table template="2" second_col="loyalty" title="Loyalty Programs"]

// Template 1 with live casino feature
[casinos_table template="1" second_col="live_casino" title="Live Casino Availability"]
```

**Template Features:**

**Template 1 Features:**
- Static table layout
- Fixed second column content
- Simple YES/NO badges for features
- Direct links to casino reviews
- Responsive design

**Template 2 Features:**
- Dynamic table with interactive column selection
- AJAX-powered content loading
- Dropdown selector for column type
- Real-time content updates
- Enhanced user experience
- Support for all column types including games list and contact info

**Casino Search Shortcode**

```
[casino_search placeholder="Search casinos..." button_text="Search" show_filters="true" results_per_page="12"]
```

**Available Parameters:**

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `placeholder` | string | "Search casinos..." | Search input placeholder text |
| `button_text` | string | "Search" | Search button text |
| `show_filters` | boolean | "true" | Show category filters |
| `results_per_page` | integer | 12 | Number of results per page |

## 🎯 Performance

### Optimization Features
- **Lazy Loading** - Images load as needed
- **Optimized Queries** - Efficient database queries
- **Minified Assets** - Compressed CSS and JS
- **Caching Ready** - Compatible with caching plugins

### Performance Tips
1. Use a caching plugin (WP Rocket, W3 Total Cache)
2. Optimize images before upload
3. Use a CDN for assets
4. Enable GZIP compression

## 🔒 Security

### Security Features
- **Nonce Verification** - CSRF protection
- **Data Sanitization** - Input validation
- **Escaped Output** - XSS protection
- **WordPress Standards** - Follows WordPress coding standards

## 🌐 Translation

### Adding Translations

1. **Create translation file**
   ```bash
   # Copy the .pot file
   cp languages/casino-theme.pot languages/casino-theme-{locale}.po
   ```

2. **Translate strings**
   - Open the .po file in a translation editor
   - Translate all strings
   - Generate .mo file

3. **Install translation**
   - Upload .mo file to `/languages/` directory
   - Set locale in WordPress settings

## 🤝 Contributing

### Contributing Guidelines

1. **Fork the repository**
2. **Create feature branch**
   ```bash
   git checkout -b feature/your-feature-name
   ```
3. **Make changes**
4. **Test thoroughly**
5. **Submit pull request**

### Code Standards
- Follow WordPress coding standards
- Use proper PHP documentation
- Test on multiple devices
- Ensure accessibility compliance

## 📄 License

This theme is licensed under the GNU General Public License v2 or later.

## 👨‍💻 Author

**Roland Esakia**
- Website: [https://casino.buildweb.dev](https://casino.buildweb.dev)
- Email: [contact@buildweb.dev](mailto:contact@buildweb.dev)

## 🆘 Support

### Getting Help

1. **Documentation** - Check this README first
2. **Issues** - Create an issue on [GitHub](https://github.com/roltex/casino-theme/issues)
3. **Contact** - Email the author for support

### Common Issues

**Theme not activating**
- Check PHP version compatibility
- Verify file permissions
- Check for conflicting plugins

**Custom fields not showing**
- Ensure custom post types are registered
- Check if meta boxes are properly configured
- Verify database permissions

## 🔄 Changelog

### Version 1.0.0
- Initial release
- Glass morphism design
- Custom post types (Casino, Game)
- Rating system
- Responsive design
- Bootstrap 5 integration

## 🎉 Credits

- **Bootstrap 5** - Frontend framework
- **Font Awesome** - Icons
- **Google Fonts** - Typography
- **WordPress** - CMS platform

---

**Made with ❤️ by Roland Esakia**

**Repository**: [https://github.com/roltex/casino-theme](https://github.com/roltex/casino-theme) 