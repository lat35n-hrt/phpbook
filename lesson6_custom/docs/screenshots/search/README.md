# Search Feature Screenshots

This directory contains screenshots demonstrating the different test scenarios for the search feature.

## Basic Search

These screenshots cover basic search functionality.

*   **Empty Input (`empty_saerch.png`):** Shows a behavior when search input is empty in all fields (price and year).
    ![Empty Input](basic_search/empty_search.png)
*   **All Valid Input (`all_fields_valid.png`):** Shows a successful search with valid input in all fields (price and year).
    ![Valid Input](basic_search/all_fields_valid.png)

## Price Filtering

These screenshots demonstrate price filtering.

*   **Both Prices (`both_prices.png`):** Shows filtering with both minimum and maximum prices.
    ![Both Prices](price_filtering/both_prices.png)
*   **Minimum Price Only (`min_price_only.png`):** Shows filtering with only a minimum price.
    ![Minimum Price Only](price_filtering/min_price_only.png)
*   **Maximum Price Only (`max_price_only.png`):** Shows filtering with only a maximum price.
    ![Maximum Price Only](price_filtering/max_price_only.png)
*   **Minimum Price zero (`min_price_zero.png`):** Shows filtering with a minimum price of 0, effectively showing all books regardless of price.
    ![Minimum Price Only](price_filtering/min_price_zero.png)
*   **Maximum Price zero (`max_price_zero.png`):** Shows filtering with a maximum price of 0, displaying only free books (if any).
    ![Maximum Price Only](price_filtering/max_price_zero.png)

## Year Filtering

These screenshots demonstrate year filtering.

*   **Specific Year (`specific_year.png`):** Shows filtering by a specific year (e.g., 2020).
    ![Specific Year](year_filtering/specific_year.png)
*   **Invalid Year (`invalid_year.png`):** ** Shows the error message displayed when a non-4-digit year (e.g., "123") is entered.
    ![Invalid Year](year_filtering/invalid_year.png)
