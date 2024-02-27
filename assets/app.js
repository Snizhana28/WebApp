const terms = document.getElementById('terms'); // це чекбокс, який вказує, що користувач погоджується з умовами
const submit = document.getElementById('submit'); // це кнопка, яка відправляє форму

terms.addEventListener('change', (e) => {
   submit.disabled = !e.currentTarget.checked;
}); // якщо чекбокс не вибраний, то кнопка відправки форми не активна