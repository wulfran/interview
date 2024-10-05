const mix = require('laravel-mix');
const webpack = require('webpack')
const dotenv = require('dotenv')
dotenv.config()

const envVars = Object.keys(process.env)
    .filter(key => key.startsWith('MIX_'))
    .reduce((arr, key) => {
        arr[key] = JSON.stringify(process.env[key])
        return arr
    }, {})

mix.ts('resources/js/app.ts', 'public/js').vue({version: 3})
    .postCss('resources/css/app.css', 'public/css', [
        require('postcss-import'),
        require('tailwindcss'),
    ])
    .alias({
        '@': 'resources/js',
    })
    .webpackConfig({
        plugins: [
            new webpack.DefinePlugin({
                "process.env": {...envVars}
            })
        ]
    })
