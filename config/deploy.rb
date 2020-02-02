# config valid for current version and patch releases of Capistrano
lock "~> 3.11.2"

set :application, "sf_progesco"
set :repo_url, "git@github.com:farochell/sf_progesco.git"
set :scm, "git"
set :deploy_to, "/v2"
set :branch, "master"

set :user, "farochell"
set :password, "P|errE130512!"
set :tmp_dir, "/tmp/capistrano"
set :bin_path, "bin"
set :config_path, "config"
set :var_path, "var"
set :web_path, "public"

set :log_path, "var/log"
set :cache_path, "var/cache"

set :symfony_console_path, "bin/console"
set :symfony_console_flags, "--no-debug"

# asset management
set :assets_install_path, "public"
set :assets_install_flags,  '--symlink'

# Share files/directories between releases
set :linked_dirs, ["var/log"]
set :linked_files, []
# To use a .env file:
#set :linked_files, [".env"]

# Set correct permissions between releases, this is turned off by default
set :file_permissions_paths, ["var"]
set :permission_method, false

# Role filtering
set :symfony_roles, :all
set :symfony_deploy_roles, :all

# Add extra environment variables:
set :default_env, {
 'APP_ENV' => 'prod'
}



# Default branch is :master
# ask :branch, `git rev-parse --abbrev-ref HEAD`.chomp

# Default deploy_to directory is /var/www/my_app_name
# set :deploy_to, "/var/www/my_app_name"

# Default value for :format is :airbrussh.
# set :format, :airbrussh

# You can configure the Airbrussh format using :format_options.
# These are the defaults.
# set :format_options, command_output: true, log_file: "log/capistrano.log", color: :auto, truncate: :auto

# Default value for :pty is false
# set :pty, true

# Default value for :linked_files is []
# append :linked_files, "config/database.yml"

# Default value for linked_dirs is []
# append :linked_dirs, "log", "tmp/pids", "tmp/cache", "tmp/sockets", "public/system"

# Default value for default_env is {}
# set :default_env, { path: "/opt/ruby/bin:$PATH" }

# Default value for local_user is ENV['USER']
# set :local_user, -> { `git config user.name`.chomp }

# Default value for keep_releases is 5
# set :keep_releases, 5

# Uncomment the following to require manually verifying the host key before first deploy.
# set :ssh_options, verify_host_key: :secure
ask(:password, "P|errE130512!**")
server 'home752037904.1and1-data.host', user: 'u94734452', port: 22, password: fetch(:password), roles: %w{web app db}