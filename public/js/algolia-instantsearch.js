(function () {
    const search = instantsearch({
        appId: "51LOD6NL6O",
        apiKey: "7bec637ff57a64e4a6c9109bc7baf0f2",
        indexName: "products",
        urlSync: true,
    });

    search.addWidget(
        instantsearch.widgets.hits({
            container: "#hits",
            templates: {
                empty: "No results",
                item: function (item) {
                    return `
                    <a href="${window.location.origin}/shop/${item.slug}">
                        <div class="instantsearch-result">
                            <div>
                                <img src="${window.location.origin}/images/${
                        item.image
                    }" alt="${item.name}" class="algolia-thumb-result">
                            </div>
                            <div>
                                <div class="result-title">
                                    ${item._highlightResult.name.value}
                                </div>
                                <div class="result-details">
                                    ${item._highlightResult.details.value}
                                </div>
                                <div class="result-price">
                                    $${(item.price / 100).toFixed(2)}
                                </div>
                            </div>
                        </div>
                    </a>
                    <hr>
                `;
                },
            },
        })
    );

    // initialize SearchBox
    search.addWidget(
        instantsearch.widgets.searchBox({
            container: "#search-box",
            placeholder: "Search for products",
        })
    );

    // initialize pagination
    search.addWidget(
        instantsearch.widgets.pagination({
            container: "#pagination",
            maxPages: 20,
            // default is to scroll to 'body', here we disable this behavior
            scrollTo: false,
        })
    );

    search.addWidget(
        instantsearch.widgets.stats({
            container: "#stats-container",
        })
    );

    // initialize RefinementList
    search.addWidget(
        instantsearch.widgets.refinementList({
            container: "#refinement-list",
            attributeName: "categories",
            sortBy: ["name:asc"],
        })
    );

    search.start();
})();
