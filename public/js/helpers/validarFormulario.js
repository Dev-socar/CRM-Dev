const validarFormulario = (
  formElements,
  errorMessages,
  passwordRequired = true
) => {
  const errorMessagesElements = document.querySelectorAll(".error-message");
  errorMessagesElements.forEach((msg) => msg.remove());

  let errores = 0;
  for (let key in formElements) {
    const input = formElements[key];
    if (input.value.trim() === "") {
      if (input.id === "password" && !passwordRequired) continue;
      input.classList.add("border", "border-red-500");

      const errorMessage = document.createElement("span");
      errorMessage.classList.add("error-message", "text-red-500", "text-sm");
      errorMessage.textContent = errorMessages[key];

      input.parentNode.appendChild(errorMessage);
      errores++;
    } else {
      input.classList.remove("border-red-500");
    }
    if (
      input.id === "telefono" &&
      input.value.trim() !== "" &&
      input.value.length !== 10
    ) {
      const phoneErrorMessage = document.createElement("span");
      phoneErrorMessage.classList.add(
        "error-message",
        "text-red-500",
        "text-sm"
      );
      phoneErrorMessage.textContent = "Longitud máxima de 10 dígitos";

      input.classList.add("border", "border-red-500");
      input.parentNode.appendChild(phoneErrorMessage);
      errores++;
    }
  }
  return errores === 0;
};

export { validarFormulario };
