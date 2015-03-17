set   :application,   "quizz"
set   :deploy_to,     "/var/www/quizz"
set   :domain,        "37.187.66.145"

set   :user,          "root"

set   :scm,           "git"
set   :repository,    "git@bitbucket.org:lsoudade/quizz.git"
set   :branch,        "master"
set   :use_composer,  true

role  :web,           domain
role  :app,           domain
role  :db,            domain, :primary => true

default_run_options[:pty] = true
logger.level = Logger::MAX_LEVEL

after "deploy:finalize_update" do
  run "cd #{release_path} && php /var/www/composer.phar install"
  run "mv #{release_path}/config/persistence.inc.php.sample #{release_path}/config/persistence.inc.php"
  run "rm #{release_path}/www/index_dev.php"
  run "php #{release_path}/bin/console.php sitemap:generate"
end

set   :use_sudo,      false
set   :keep_releases, 5
after "deploy", "deploy:cleanup"