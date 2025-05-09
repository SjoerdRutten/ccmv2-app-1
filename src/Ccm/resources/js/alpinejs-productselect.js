document.addEventListener("alpine:init", () => {
    Alpine.data("productSelect", (obj) => ({
        value: obj.value,
        elements: [],
        productIds: [],    // Array met geselecteerde product ids
        selectedProducts: [],
        search: '',         // Zoekstring
        searchResult: [],   // Zoek resultaten
        init() {
            this.$watch("search", (e => {
                this.searchProducts()
            }))
            this.$watch("searchResult", (e => {
            }))
            this.$watch("productIds", (e => {
                this.getSelectedProducts()
                this.value = this.productIds.join(',')
            }))

            this.productIds = this.value.split(',')
        },
        async getSelectedProducts() {
            var data = await fetch('/jsapi/product/selected?' + new URLSearchParams({
                ids: this.productIds,
            }).toString())
                .then(res => res.json())
                .then(
                    function (data) {
                        return data
                    }
                )

            this.selectedProducts = data
        },
        async searchProducts() {
            this.searchResult = []
            if (this.search.length > 2) {
                var data = await fetch('/jsapi/product/search?' + new URLSearchParams({
                    q: this.search,
                }).toString())
                    .then(res => res.json())
                    .then(
                        function (data) {
                            return data
                        }
                    )

                this.searchResult = data
                this.filterAddedProductsFromSearchResults()
            }
        },
        addProduct(id) {
            this.productIds.push(id)
            this.filterAddedProductsFromSearchResults()
        },
        addAllProducts() {
            this.searchResult.forEach(element => {
                this.addProduct(element.id)
            })
        },
        removeProduct(index) {
            this.productIds.splice(index, 1)
            this.searchProducts()
        },
        removeAll() {
            this.productIds = []
            this.searchProducts()
        },
        filterAddedProductsFromSearchResults() {
            var $this = this

            this.searchResult = this.searchResult.filter(
                function (product) {
                    return $this.productIds.indexOf(product.id) < 0
                }
            )
        }
    }));
});
