<!-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> -->
<script>
    $('#' + <?= $region_id ?>).select2({
        placeholder: 'Pilih ',
        ajax: {
            url: "<?= base_url('extra/get_regions') ?>",
            dataType: 'json',
            data: function(params) {
                var query = {
                    search: params.term,
                    page: params.page || 1
                }

                // Query parameters will be ?search=[term]&page=[page]
                return query;
            },
            processResults: function(data, params) {
                var dt = $.map(data.data, function(obj) {
                    obj.id = obj.id || obj.pk; // replace pk with your identifier
                    obj.text = obj.text || obj.region;
                    return obj;
                });
                // Transforms the top-level key of the response object from 'items' to 'results'
                return {
                    results: dt,
                    pagination: {
                        more: (params.page * 10) < data.count_filtered
                    }
                };
            }
            // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
        }
    });
    <?php if($areas == 1){ ?>
    $('#' + <?= $region_id ?>).on('select2:select', function(e) {
        var data = e.params.data;
        $('#' + <?= $area_id ?>).select2({
            ajax: {
                url: "<?= base_url('extra/get_areas') ?>/" + data.id,
                dataType: 'json',
                data: function(params) {
                    var query = {
                        search: params.term,
                        page: params.page || 1
                    }

                    // Query parameters will be ?search=[term]&page=[page]
                    return query;
                },
                processResults: function(data, params) {
                    var dt = $.map(data.data, function(obj) {
                        obj.id = obj.id || obj.pk; // replace pk with your identifier
                        obj.text = obj.text || obj.area;
                        return obj;
                    });
                    // Transforms the top-level key of the response object from 'items' to 'results'
                    return {
                        results: dt,
                        pagination: {
                            more: (params.page * 10) < data.count_filtered
                        }
                    };
                }
                // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
            }
        });
    });
    <?php } ?>
    <?php if($subdistrict == 1){ ?>
    $('#' + <?= $area_id ?>).on('select2:select', function(e) {
        var data = e.params.data;
        $('#' + <?= $subdistrict_id ?>).select2({
            ajax: {
                url: "<?= base_url('extra/get_subdistrict') ?>/" + data.id,
                dataType: 'json',
                data: function(params) {
                    var query = {
                        search: params.term,
                        page: params.page || 1
                    }

                    // Query parameters will be ?search=[term]&page=[page]
                    return query;
                },
                processResults: function(data, params) {
                    var dt = $.map(data.data, function(obj) {
                        obj.id = obj.id || obj.pk; // replace pk with your identifier
                        obj.text = obj.text || obj.subdistrict_name;
                        return obj;
                    });
                    // Transforms the top-level key of the response object from 'items' to 'results'
                    return {
                        results: dt,
                        pagination: {
                            more: (params.page * 10) < data.count_filtered
                        }
                    };
                }
                // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
            }
        });
    });
    <?php } ?>
</script>