## Tasks

- [ ] Eliminate `config.php` in `Configuration` folder. There are lots of files just including this to include DataAccessLayer (which is in the `Configuration/config.php`)
- [ ] Combine all variables into the root config.php file. The files I could find have some prod/dev different constants are:
  - `ulogin/config/main.inc.php #L16`
  - `ulogin/config/main.inc.php #L183`
  - `ulogin/config/pdo.inc.php #L11`