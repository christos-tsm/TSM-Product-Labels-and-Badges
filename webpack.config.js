const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');

module.exports = {
    entry: {
        main: './assets/js/main.js', // JavaScript entry
        adminStyles: './assets/css/admin-tailwind.css', // CSS-only entry
    },
    output: {
        path: path.resolve(__dirname, 'build'),
        filename: (pathData) => {
            // Only output JS files for JS entries
            return pathData.chunk.name === 'main' ? 'js/[name].js' : 'js/[name].no-js'; // Avoids creating unnecessary adminStyles.js
        },
    },
    module: {
        rules: [
            {
                test: /\.css$/,
                use: [
                    MiniCssExtractPlugin.loader,
                    'css-loader',
                    'postcss-loader',
                ],
            },
        ],
    },
    plugins: [
        new MiniCssExtractPlugin({
            filename: 'css/[name].css', // CSS files go to build/css/
        }),
    ],
    mode: process.env.NODE_ENV === 'production' ? 'production' : 'development',
};
