<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://brino.sk
 * @since      1.0.0
 *
 * @package    Brino_Sync
 * @subpackage Brino_Sync/admin/partials
 */
?>
<div class="p-5">
  <h3>Select categories to sync with Brino</h3>
  <div class="d-flex flex-row pb-2 justify-content-between">
    <div class="d-flex align-items-center">
      <p class="mb-0">
        Select the categories you want to add to brino
      </p>
    </div>
  </div>
  <?php

  function postCategories()
  {
    $product_categories = get_terms(
      array(
        'taxonomy' => 'product_cat',
        'hide_empty' => false,
      )
    );

    // echo '<pre>';
    // print_r($product_categories);
    // echo '</pre>';
  
    $selected_categories = array_filter($product_categories, function ($category) {
      return in_array($category->term_id, $_POST["cat"]);
    });

    $apikey = get_option('brinnoApikey');

    // echo $apikey;
  
    foreach ($selected_categories as $product_category) {
      $response = wp_remote_post(
        "https://api.brino.sk/api/v1/cms/",
        array(
          'headers' => array(
            'Authorization' => 'Bearer ' . $apikey,
            'Content-Type' => 'application/x-www-form-urlencoded',
          ),
          'body' => array(
            'id' => $product_category->term_id,
            'name' => $product_category->name,
            'description' => $product_category->description,
            'slug' => $product_category->slug,
          ),
        ),
      );

      if (is_wp_error($response)) {
        // Log the error
        echo $response->get_error_message();
        return;
      }

      echo "<h4>Synced</h4>";

      echo '<pre>';
      print_r($response);
      echo '</pre>';
    }
  }

  if (isset($_POST['submit']) && isset($_POST['cat'])) {
    postCategories();
  }

  ?>
  <form method="POST">
    <input type="submit" value="click" name="submit"> <!-- assign a name for the button -->

    <table class='wp-list-table widefat fixed striped table-view-list tags ui-sortable'>
      <thead>
        <tr>
          <td id="cb" class="manage-column column-cb check-column">
            <label class="screen-reader-text" for="cb-select-all-1">Vybrať všetko</label>
            <input id="cb-select-all-1" type="checkbox">
          </td>
          <th scope="col" id="id" class="manage-column column-name column-primary sortable desc">
            <a
              href="https://new.brino.sk/wp-admin/edit-tags.php?taxonomy=product_cat&amp;post_type=product&amp;orderby=name&amp;order=asc">
              <span>ID</span><span class="sorting-indicator"></span>
            </a>
          </th>
          <th scope="col" id="name" class="manage-column column-name column-primary sortable desc">
            <a
              href="https://new.brino.sk/wp-admin/edit-tags.php?taxonomy=product_cat&amp;post_type=product&amp;orderby=name&amp;order=asc">
              <span>Názov</span><span class="sorting-indicator"></span>
            </a>
          </th>
          <th scope="col" id="description" class="manage-column column-description sortable desc">
            <a
              href="https://new.brino.sk/wp-admin/edit-tags.php?taxonomy=product_cat&amp;post_type=product&amp;orderby=description&amp;order=asc">
              <span>Popis</span><span class="sorting-indicator"></span>
            </a>
          </th>
          <th scope="col" id="slug" class="manage-column column-slug sortable desc">
            <a
              href="https://new.brino.sk/wp-admin/edit-tags.php?taxonomy=product_cat&amp;post_type=product&amp;orderby=slug&amp;order=asc">
              <span>Slug</span><span class="sorting-indicator"></span>
            </a>
          </th>
        </tr>
      </thead>
      <tbody>
        <?php

        $taxonomy = 'product_cat';
        $orderby = 'name';
        $show_count = 0; // 1 for yes, 0 for no
        $pad_counts = 0; // 1 for yes, 0 for no
        $hierarchical = 1; // 1 for yes, 0 for no  
        $title = '';
        $empty = 0;

        $args = array(
          'taxonomy' => $taxonomy,
          'orderby' => $orderby,
          'show_count' => $show_count,
          'pad_counts' => $pad_counts,
          'hierarchical' => $hierarchical,
          'title_li' => $title,
          'hide_empty' => $empty
        );
        $all_categories = get_categories($args);

        foreach ($all_categories as $cat) {
          if ($cat->category_parent == 0) {
            $category_id = $cat->term_id;
            echo '<tr id="tag-16" class="level-0">
                    <th scope="row" class="check-column">
                      <label class="screen-reader-text" for="cb-select-16"
                        >Vybrať Category 1</label
                      ><input type="checkbox" name="cat[]" value="' . $cat->term_id . '" id="cb-select-16" />
                    </th>
                    <td class="name column-name has-row-actions column-primary" name="ID">
                      <strong>' . $cat->term_id . '</strong>
                    </td>
                    <td
                      class="name column-name has-row-actions column-primary"
                      data-colname="Názov"
                    >
                      <a
                        class="row-title"
                        href="' . get_term_link($cat->slug, 'product_cat') . '"
                        aria-label="“' . $cat->name . '” (Upraviť)"
                        >' . $cat->name . '</a
                      >
                    </td>
                    <td class="description column-description" data-colname="Popis">
                      <p>' . $cat->description . '</p>
                    </td>
                    <td
                      class="name column-name has-row-actions column-primary"
                      data-colname="Slug"
                    >
                      <strong>' . $cat->slug . '</strong>
                    </td>
                  </tr>';

            $args2 = array(
              'taxonomy' => $taxonomy,
              'child_of' => 0,
              'parent' => $category_id,
              'orderby' => $orderby,
              'show_count' => $show_count,
              'pad_counts' => $pad_counts,
              'hierarchical' => $hierarchical,
              'title_li' => $title,
              'hide_empty' => $empty
            );
            $sub_cats = get_categories($args2);
            if ($sub_cats) {
              foreach ($sub_cats as $sub_category) {
                echo '<tr id="tag-16" class="level-1">
                            <th scope="row" class="check-column">
                              <label class="screen-reader-text" for="cb-select-16"
                                >Vybrať Category 1</label
                              ><input type="checkbox" name="cat[]" value="' . $sub_category->term_id . '" id="cb-select-16" />
                            </th>
                            <td class="name column-name has-row-actions column-primary" name="ID">
                              <strong>' . $sub_category->term_id . '</strong>
                            </td>
                            <td
                              class="name column-name has-row-actions column-primary"
                              data-colname="Názov"
                            >
                              <a
                                class="row-title"
                                href="' . get_term_link($sub_category->slug, 'product_cat') . '"
                                aria-label="“' . $sub_category->name . '” (Upraviť)"
                                >' . $sub_category->name . '</a
                              >
                            </td>
                            <td class="description column-description" data-colname="Popis">
                              <p>' . $sub_category->description . '</p>
                            </td>
                            <td
                              class="name column-name has-row-actions column-primary"
                              data-colname="Slug"
                            >
                              <strong>' . $sub_category->slug . '</strong>
                            </td>
                          </tr>';
              }
            }
          }
        }
        ?>
      </tbody>
    </table>
    <form>
</div>

<!-- //possible solution https://stackoverflow.com/questions/21009516/get-woocommerce-product-categories-from-wordpress -->
<!-- /**
     * Lists all product categories and sub-categories in a tree structure.
     *
     * @return array
     */
    function list_product_categories() {
        $categories = get_terms(
            array(
                'taxonomy'   => 'product_cat',
                'orderby'    => 'name',
                'hide_empty' => false,
            )
        );

        $categories = treeify_terms($categories);

        return $categories;
    }

    /**
     * Converts a flat array of terms into a hierarchical tree structure.
     *
     * @param WP_Term[] $terms Terms to sort.
     * @param integer   $root_id Id of the term which is considered the root of the tree.
     *
     * @return array Returns an array of term data. Note the term data is an array, rather than
     * term object.
     */
    function treeify_terms($terms, $root_id = 0) {
        $tree = array();

        foreach ($terms as $term) {
            if ($term->parent === $root_id) {
                array_push(
                    $tree,
                    array(
                        'name'     => $term->name,
                        'slug'     => $term->slug,
                        'id'       => $term->term_id,
                        'count'    => $term->count,
                        'children' => treeify_terms($terms, $term->term_id),
                    )
                );
            }
        }

        return $tree;
    } -->