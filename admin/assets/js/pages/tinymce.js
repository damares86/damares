document.addEventListener("DOMContentLoaded", () => {
  console.log("initing", document.body.classList.contains("theme-dark"))

  const themeOptions = document.body.classList.contains("theme-dark")
    ? {
        skin: "oxide-dark",
        content_css: "dark",
      }
    : {
        skin: "oxide",
        content_css: "default",
      }

  // tinymce.init({ selector: "#default", ...themeOptions })
  // tinymce.init({
  //   selector: "#default",
  //   toolbar:
  //     "undo redo styleselect bold italic alignleft aligncenter alignright bullist numlist outdent indent link code",
  //   plugins: "code lists link",
  //   ...themeOptions,
  // })
  tinymce.init({
    selector: ".tiny",
    toolbar:
      "undo redo styleselect bold italic alignleft aligncenter alignright bullist numlist outdent indent link code",
    plugins: "code lists link",
    ...themeOptions,
    height: 400, // Imposta l'altezza dell'editor
    // menubar: false, // Disattiva la barra del menù se non necessaria
  })
})
