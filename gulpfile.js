var elixir = require('laravel-elixir');

elixir(function(mix) {
    mix.styles([
      'github.css'
    ]);
  
    mix.sass('app.scss');

    mix.scripts([
      'jquery.min.js',
      'bootstrap.min.js',
      'bootstrap-confirmation.min.js',
      'highlight.min.js',
      'simpas.js'
    ]);
});
