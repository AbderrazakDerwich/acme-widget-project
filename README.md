# acme-widget-shopify
E-commerce proof of concept for Acme Widget Co with a shopping basket, promotions, and dynamic delivery pricing in PHP.

# install the project locally 
1. `cp .env.dist .env`
2. RUN `make up` (to build the first time & run services)
3. RUN `make install` (to install composer dependencies)
4. RUN `make info` (to get the links to the app and phpmyadmin)

# Project Description
This project contains an interface that displays a list of products and allows us to select products for our cart by choosing the product and quantity. Based on the selection, a message appears in the footer, indicating the price of the cart after reductions.
