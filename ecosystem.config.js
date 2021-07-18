module.exports = {
  apps : [{
	name: "cadunesc.com.br",
	script: 'php artisan serve',
  }],
  deploy : {
    production : {
      user : 'ubuntu',
      host : '51.79.87.90',
      ref  : 'origin/master',
      repo : 'git@github.com:domingues93/cadunesc.com.br.git',
      path : '/home/ubuntu/cadunesc.com.br/web',
      'pre-deploy-local': '',
      'post-deploy' : 'composer install && pm2 startOrRestart ecosystem.config.js',
      'pre-setup': ''
    }
  }
};
