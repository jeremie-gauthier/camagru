<link rel="stylesheet" type="text/css" href="picture/styles/filters.css">

<div id="list-filters" aria-labelledby="btn-filters" hidden>
  <button
    type="button"
    class="filter"
    id="no-filter"
    onclick="state.pic.filter.normal()"
  >
    Sans filtre
  </button>

  <button
    type="button"
    class="filter"
    id="grey-filter"
    onclick="state.pic.filter.grey()"
  >
    Filtre gris
  </button>

  <button
    type="button"
    class="filter"
    id="sepia-filter"
    onclick="state.pic.filter.sepia()"
  >
    Filtre sepia
  </button>
</div>
