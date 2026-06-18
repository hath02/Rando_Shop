document.addEventListener('DOMContentLoaded', function () {

    /* Add to cart button click handler */
    document.querySelectorAll('.add-to-cart').forEach(btn => {
        btn.addEventListener('click', function () {
            const productId = this.dataset.id;

            const formData = new FormData();
            formData.append('product_id', productId);
            formData.append('quantity', 1);

            fetch('/shop_db/index.php?action=add_to_cart', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    alert('Added to cart!');
                } else {
                    alert(data.message || 'Failed');
                }
            })
            .catch(err => console.error(err));
        });
    });

/* Zoom product image on details page */
    const container = document.getElementById("zoom-container");
    const img = document.getElementById("main-product-img");
    const lens = document.getElementById("zoom-lens");

    // prevent error if not on product page
    if (container && img && lens) {

        container.addEventListener("mousemove", moveLens);
        container.addEventListener("mouseenter", () => lens.style.display = "block");
        container.addEventListener("mouseleave", () => {
            lens.style.display = "none";
            img.style.transform = "scale(1)";
        });

        function moveLens(e) {
            const rect = container.getBoundingClientRect();

            let x = e.clientX - rect.left;
            let y = e.clientY - rect.top;

            let lensWidth = lens.offsetWidth / 2;
            let lensHeight = lens.offsetHeight / 2;

            x = Math.max(lensWidth, Math.min(x, rect.width - lensWidth));
            y = Math.max(lensHeight, Math.min(y, rect.height - lensHeight));

            lens.style.left = (x - lensWidth) + "px";
            lens.style.top = (y - lensHeight) + "px";

            img.style.transformOrigin = `${(x / rect.width) * 100}% ${(y / rect.height) * 100}%`;
            img.style.transform = "scale(2)";
        }
    }

});