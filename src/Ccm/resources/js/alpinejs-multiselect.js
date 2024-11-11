document.addEventListener("alpine:init", () => {
    Alpine.data("textArray", (obj) => ({
        elements: obj.elements,
        tags: [],
        newElement: '',
        init() {
            this.tags = this.elements ? this.elements.split(",") : []

            this.tags.sort()

            this.$watch("tags", (e => {
                this.tags.sort()
                this.elements = this.tags.join(',')
            }))
            this.$watch("elements", (e => {
                this.tags = this.elements ? this.elements.split(",") : []
            }))
        },
        addElement() {
            if (this.newElement.length > 1) {
                var elements = this.newElement.split(',')

                elements.forEach(element => {
                    this.tags.push(element.trim())
                })

                this.newElement = ''
            }
        },
        removeElement(index) {
            this.tags.splice(index, 1)
        },
        removeAll() {
            this.tags = []
        }
    }));
});
