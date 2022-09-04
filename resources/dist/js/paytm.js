function openJsCheckoutPopup(orderId, txnToken, amount, redirect) {
    var config = {
        "root": "",
        "flow": "DEFAULT",
        "data": {
            "orderId": orderId,
            "token": txnToken,
            "tokenType": "TXN_TOKEN",
            "amount": amount
        },
        "merchant": {
            "redirect": redirect ?? true
        },
        "handler": {
            notifyMerchant: function notifyMerchant(eventName, data) {
                console.log("eventName => ", eventName);
                // console.log("data => ", data); // only enable for debugging
            },
            transactionStatus: function transactionStatus(paymentStatus) {
                paymentCompleted(paymentStatus); // only called when redirect is set to false
            }
        }
    };

    if (window.Paytm && window.Paytm.CheckoutJS) {
        // initialze configuration using init method 
        window.Paytm.CheckoutJS.init(config).then(function onSuccess() {
            // after successfully updating configuration, invoke JS Checkout
            window.Paytm.CheckoutJS.invoke();
        }).catch(function onError(error) {
            console.log("error => ", error);
        });
    }
}