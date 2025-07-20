    <script>
      document.querySelectorAll('.card').forEach(function(card) {
        const priceElem = card.querySelector('.price');
        const discountElem = card.querySelector('.discount');
        const original = parseFloat(priceElem.getAttribute('data-original'));
        const discount = parseInt(priceElem.getAttribute('data-discount'));
        const discounted = (original * (1 - discount / 100)).toFixed(2);

        priceElem.innerHTML = `<del>$${original}</del> <strong>$${discounted}</strong>`;
        discountElem.textContent = `Discount: ${discount}%`;
      });
    </script>