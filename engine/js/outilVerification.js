function nombreValide(input) {
    input.value = input.value.replace(/[^0-9]/g, '').substring(0, 5);
}
