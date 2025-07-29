  document.addEventListener('DOMContentLoaded', () => {

      if (typeof paypal === 'undefined' || !paypal.Buttons) {
        console.error('PayPal SDK no está disponible.');
        return;
      }

      paypal.Buttons({
        style: {
          layout: 'vertical',
          color:  'gold',
          shape:  'rect',
          label:  'donate'
        },
        // Crea la orden con el monto del input
        createOrder: (data, actions) => {
          const value = document.getElementById('amount').value;
          return actions.order.create({
            purchase_units: [{
              description: 'Donación Perritos Callejeros',
              amount: { value }
            }]
          });
        },
        //Captura la orden y agradecer
        onApprove: (data, actions) => {
          return actions.order.capture().then(details => {
            const name = details.payer.name.given_name || 'amigo';
            alert(`¡Gracias ${name}! Tu donación de \$${details.purchase_units[0].amount.value} ha sido recibida.`);
            // redirije a página de éxito
             window.location.href = 'success.php';
          });
        },
        onError: err => {
          console.error(err);
          alert('Ocurrió un error en el pago. Por favor, inténtalo de nuevo.');
        }
      }).render('#paypal-button-container');
    });
  