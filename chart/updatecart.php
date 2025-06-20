<form method="post" action="updatecart.php">
    <input type="hidden" name="quantity[<?= $id ?>]" id="qty-input-<?= $id ?>" value="<?= $qty ?>">
    <button type="button" onclick="changeQty(<?= $id ?>, -1)">−</button>
    <span id="qty-<?= $id ?>"><?= $qty ?></span>
    <button type="button" onclick="changeQty(<?= $id ?>, 1)">+</button>
    <button type="submit">Update</button>
</form>

<script>
function changeQty(id, delta) {
    const input = document.getElementById('qty-input-' + id);
    let qty = parseInt(input.value);
    qty += delta;
    if (qty < 1) qty = 1;
    input.value = qty;
    document.getElementById('qty-' + id).innerText = qty;
}
</script>
