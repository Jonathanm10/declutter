export default class ConditionallyAlert {
  constructor(linkClass, attribute, message) {
    this.linkClass = linkClass;
    this.attribute = attribute;
    this.message = message;
  }

  setAlert() {
    const deleteLink = document.querySelectorAll(this.linkClass);
    if (deleteLink.length > 0) {
      deleteLink.forEach((link) => {
        link.addEventListener('click', (e) => {
          e.preventDefault();
          if (e.currentTarget.getAttribute(this.attribute) === '1') {
            if (confirm(this.message)) {
              window.location = e.currentTarget.href;
            } else {
              return;
            }
          }
          window.location = e.currentTarget.href;
        });
      });
    }
  }
}
