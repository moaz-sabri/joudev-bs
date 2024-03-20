### Project Name: Joudev-Static

Joudev is an open-source PHP template designed to facilitate frontend and backend development, from simple to large-scale projects. It prioritizes ease of use without compromising functionality, employing modular packages for implementing new features seamlessly within the MVC architecture.

#### Getting Started

1. **Download the Project:**
   Clone or download the project from [GitHub](https://github.com/moaz-sabri/joudev-static.git).

2. **Build with Docker:**
   Ensure Docker is installed on your device, then execute the following command:
   ```bash
   docker-compose up --build -d
   ```

## Accessing the Project

Once the project is built, access it through [http://localhost:5000](http://localhost:5000).

## Project Structure

- **app:** Core of the project

  - **bootstrap:** Handles rendering requests and returning responses.
  - **modules:** Packages of features.
  - **templates:** Global components.
  - **utilities:** Global tools and functions.
  - **autoload.inc:** Autoload configuration file.

- **public:** Client-side files

  - **index.html:** Main entry point.
  - **assets:** Media files (images, videos, etc.).
  - **static:** Resources (CSS, JS, etc.).

- **dockerfile:** Configuration for Docker.
- **.htaccess:** Apache server configuration file.
- **etc ...**

## Landing Page Setup

To configure the landing page:

1. Open `app/bootstrap/web.php`.

   - Add the desired paths:
     ```php
     private static $paths = [
         'home' => '',     // Landing page path (empty string)
         'about' => 'about'  // About page path ('about')
     ];
     ```

2. In `App\Modules\Public`, define the route for the landing page:
   ```php
   $router->get($this->getPath('home'), new PublicController, 'index');
   ```

## Implement the Landing Page Controller

In `App\Modules\Public\Controller`, implement the landing page controller:

```php
public function index()
{
    return (object) [
        'view' => PublicUrls::$resource . 'index',
        'meta' => ['title' => 'Home | ' . PROJECT_NAME]
    ];
}
```

## Create an index.blade.php file in App\Modules\Public\views

Create an `index.blade.php` file in `App\Modules\Public\views` to add the layout.

## New Addition

### Translation Extension

To use translation, call in the HTML code:

```html
<h1><?= $this->label->get('word') ?></h1>
```

where 'word' is defined in /storage/languages/en/index.xml for English. You can manually add new words to the XML file like:

```xml
<phrase name="newword">newWord</phrase>
```

and add new languages like `/storage/languages/xLanguage/index.xml`. Then add the new short name to existLanguages in `\app\extends\translation\loader\languageloader.php`.

## New Updates

- Removed Web class and implemented new logic for Routes.
- Added a new class to FailResponse to return error pages.
- Added default pages like policy and impression.
- Updated Navbar, Footer, and index Design.

Now, you have a complete simple project set up and ready to be expanded upon and updated for the next level of development.

<!-- ___________________________ -->

Now, you have a complete simple project set up and ready to be expanded upon and updated for the next level of development.

## Contributing

Contributions are welcome! Feel free to open issues or submit pull requests to improve the project.

## License

This project is licensed under the MIT License.
