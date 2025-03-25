$(document).ready(function() {
    // Trigger the function when the checkbox is checked/unchecked
    $('.form-check-input').on('change', function() {
        updateCheckedProducts();
    });

    // Trigger the function when the number input value changes
    $('input[type="number"]').on('change', function() {
        updateCheckedProducts();
    });

    function updateCheckedProducts() {
        var checkedProducts = {};
        // Loop through all checked checkboxes
        $('.form-check-input:checked').each(function() {
            var productCode = $(this).val();
            var productQuantity = $(this).closest('.form-check').find('input[type="number"]').val();
            checkedProducts[productCode] = productQuantity;
        });

        $.ajax({
            url: 'index.php', 
            type: 'POST',
            data: {
                checked_products: checkedProducts
            },
            dataType: 'json',
            success: function(response) {
                $totalDisplay = $('#total-display');
                if (response.checked_products !== undefined && response.checked_products !== null) {
                    if (!$totalDisplay.length) {
                        $totalDisplay = $(`
                            <p id="total-display" class="total-display-cart">
                                Your total cart is: <span class="total-price">${response.checked_products} $</span>
                            </p>
                        `).insertAfter('#products-list');
                    } else {
                        $totalDisplay.html(`Your total cart is: <span class="total-price">${response.checked_products} $</span>`);
                    }
                } else {
                    $totalDisplay.remove();
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });
    }
});
