//# - ID
//. = class

//    $(document).on("click", function (e) {
//        console.log(e);
//    });

// Populates drop down for "Select A Saved Address Profile:"
function load_aliases() {
    $.ajax({
        type: 'POST',
        url: 'checkout-process.php',
        data: {operation: "address_alias"},
        success: function (data) {
            $("#alias-dropdown").html(data);
        }
    });
}

// After value selected from "Select A Saved Address Profile:" dropdown, populate corresponding fields
function load_address_details(address_id) {
    $.ajax({
        type: 'POST',
        url: 'checkout-process.php',
        data: {operation: "load-address", address_id: address_id},
        success: function (data) {
            var details = JSON.parse(data);

            $("#address-id").html(address_id);
            $("#address-id").val(address_id);
            $("#address-field").html(details.address);
            $("#address-field").val(details.address);
            $("#unit-no-field").html(details.unit_no);
            $("#unit-no-field").val(details.unit_no);
            $("#postal-code-field").html(details.postal_code);
            $("#postal-code-field").val(details.postal_code);
        }
    });
}

// Populates drop down for "Select An Existing Card Profile:"
function load_card_profiles() {
    $.ajax({
        type: 'POST',
        url: 'checkout-process.php',
        data: {operation: "credit_owner"},
        success: function (data) {
            $("#credit-dropdown").html(data);
        }
    });
}

// After value selected from "Select An Existing Card Profile:" dropdown, populate corresponding fields
function load_card_details(payment_id) {
    $.ajax({
        type: 'POST',
        url: 'checkout-process.php',
        data: {operation: "load-card-details", payment_id: payment_id},
        success: function (data) {
            var details = JSON.parse(data);

            $("#payment-id").html(payment_id);
            $("#payment-id").val(payment_id);
            $("#owner-field").html(details.owner);
            $("#owner-field").val(details.owner);
            $("#account-no-field").html(details.account_no);
            $("#account-no-field").val(details.account_no);
            $("#expiry-date-field").html(details.expiry);
            $("#expiry-date-field").val(details.expiry);
        }
    });
}

//Startup Function
function autoexec() {
    // Function only runs on checkout.php
    if ((window.location.href).includes("checkout.php")) {
        load_aliases();
        load_card_profiles();
    }
}

$(document).ready(function () {
    autoexec();

    // When "Select A Saved Address Profile:" dropdown changes
    $(document).on('change', '#alias-dropdown', function () {
        if ($(this).val() === "empty") {
            $("#address-id").html("");
            $("#address-id").val("");
            $("#address-field").html("- Select an Address -");
            $("#address-field").val("");
            $("#unit-no-field").html("");
            $("#unit-no-field").val("");
            $("#postal-code-field").html("");
            $("#postal-code-field").val("");
        } else {
            load_address_details($('option:selected', this).attr('identifier'));
        }
    });

    // When "Select An Existing Card Profile:" dropdown changes
    $(document).on('change', '#credit-dropdown', function () {
        if ($(this).val() === "empty") {
            $("#payment-id").html("");
            $("#payment-id").val("");
            $("#owner-field").html("- Select a Card -");
            $("#owner-field").val("");
            $("#account-no-field").html("");
            $("#account-no-field").val("");
            $("#expiry-date-field").html("");
            $("#expiry-date-field").val("");
        } else {
            load_card_details($('option:selected', this).attr('identifier'));
        }
    });
});