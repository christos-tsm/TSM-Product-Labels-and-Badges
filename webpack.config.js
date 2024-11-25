const path = require('path');

module.exports = {
    entry: {
        main: './assets/js/main.js',
        styles: './assets/css/tailwind.css',
    },
    output: {
        path: path.resolve(__dirname, 'build'),
        filename: 'js/[name].js',
    },
    module: {
        rules: [
            {
                test: /\.css$/,
                use: ['style-loader', 'css-loader', 'postcss-loader'],
            },
        ],
    },
};
