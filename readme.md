# KBCS WordPress Theme

Wordpress theme code for [KBCS.fm](https://kbcs.fm), a community-driven radio station at [Bellveue College](https://bellvuecollege.edu).

## Structure of the Theme

In the main directory you will find core theme files:

- **header.php**: Contains the site title, navigation menu, and header image.
- **footer.php**: Includes copyright information, social media links, and footer widgets.
- **sidebar.php**: Displays widgets such as recent posts, categories, and archives.
- **front-page.php**: Displays the main content of the homepage, including posts and pages.
- **template-<name>.php**: Displays the main content of a custom template, usually for a specific page that queries from a category.
- **format-<name>.php**: Displays the main content of a post based on its format.
- **single-<name>.php**: Displays the main content of a single post, based on its type.
- **search.php**: Displays the main content of a search results page.
- **search-form.php**: Displays the search form.
- **page.php**: Displays the main content of a page.
- **functions.php**: Contains custom functions and hooks for the theme.
- **style.css**: Contains the theme's styles and layout.

In some of the subfolders you will find additional files:

- **inc**: Contains reusable code snippets and functions.
- **js**: Contains javascript files for the theme.

## Using this theme

For using this theme, it is suggested to develop locally using [LocalWP](https://localwp.com/). It is recommended to use a local development environment to test and debug your theme before deploying it to a live site. It is also recommended to fork this repository and create a new branch for your changes, you will need to clone this repository into your local development environment in `/wp-content/themes/<theme-name>`.

## Contributing

If you would like to contribute to this theme, please fork the repository and submit a pull request with your changes and reach out to the [BC Integrations team](https://github.com/bellevuecollege). They will be reviewed by the BC Integrations team and merged into the main branch if they meet the quality standards: including code quality, WCAG compliance, documentation, and testing.

## License

License: [GPLv2 or later](https://www.gnu.org/licenses/gpl-2.0.html)

## Acknowledgments

This theme was created by the BC Integrations team and [Drew King](https://drewking.dev/) has been a significant contributor to the project, implementing new features, accessibility improvements, and performance enhancements.
