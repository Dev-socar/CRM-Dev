

export const toast = (msg,type=false) => {
    return Toastify({
      text: msg,
      duration: 3000,
      gravity: "top",
      position: "center", 
      stopOnFocus: false, 
      style: {
          background: `${type ? "#fc0a0a" : "#1d4ed8"}`,
          color:"#FFF"
      },
      onClick: function () {},
    }).showToast();
}

