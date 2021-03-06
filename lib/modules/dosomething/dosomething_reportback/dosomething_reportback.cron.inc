<?php

/**
 * @file
 * Provides cron job/drush command for dosomething_reportback.module.
 */

/**
 * Implements hook_cron().
 */
function dosomething_reportback_cron() {
  // Get all reportbacks updated in the past hour.
  $results = db_query("SELECT n.nid, SUM(rb.quantity) as total
                       FROM node n
                       INNER JOIN field_data_field_campaign_status s on n.nid = s.entity_id
                       INNER JOIN dosomething_reportback rb on n.nid = rb.nid
                       WHERE n.type = 'campaign'
                       AND s.field_campaign_status_value = 'active'
                       AND rb.flagged = 0
                       GROUP BY n.nid;");

  // Updated reportback counts accordingly.
  foreach ($results as $result) {
    dosomething_helpers_set_variable('node', $result->nid, 'sum_rb_quantity', (int) $result->total);

    // Add a row to the reportback progress log table.
    db_insert('dosomething_reportback_progress_log')
      ->fields(array(
        'nid' => $result->nid,
        'quantity' => $result->total,
        'timestamp' => REQUEST_TIME,
        ))
      ->execute();
  }


  /**
   * Search for reportback item that have been flagged, but the reportback was not flagged.
   * @see https://github.com/DoSomething/phoenix/issues/4713
   * @see https://github.com/DoSomething/phoenix/issues/4529
   */

  db_query("UPDATE dosomething_reportback as rb
                       INNER JOIN dosomething_reportback_file as rbf on rb.rbid = rbf.rbid
                       INNER JOIN dosomething_reportback_log as rbl on rb.rbid = rbl.rbid
                       SET rb.flagged = 1, rb.flagged_reason = rbl.reason
                       WHERE rbf.status = 'flagged'
                       AND rbl.op = 'flagged'
                       AND (rb.flagged = 0 or rb.flagged is null);");

  db_query("UPDATE dosomething_reportback as rb
                      INNER JOIN dosomething_reportback_file as rbf on rb.rbid = rbf.rbid
                      INNER JOIN dosomething_reportback_log as rbl on rb.rbid = rbl.rbid
                      SET rb.promoted = 1, rb.promoted_reason = rbl.reason
                      WHERE rbf.status = 'promoted'
                      AND rbl.op = 'promoted'
                      AND (rb.promoted = 0 or rb.promoted is null);");

}
