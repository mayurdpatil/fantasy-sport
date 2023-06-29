

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
  <div class="row">
        <div class="col-lg-12">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="<?php echo SITE_URL;?>match/schedule" accept-charset="utf-8" name="frm_schedule_match" id="frm_schedule_match" method="post">
                        <div class="modal-header">
                          <h4 class="modal-title">Schedule Match</h4>
                        </div>
                        <div class="modal-body">
                        <div style="color:red">
                        <?php echo validation_errors(); ?>
                        </div>
                            <fieldset>                                
                                <!-- Drop down -->
                                <div class="control-group ">
                                    <label class="control-label" for="txt_local_team">Local Team<span class="text-danger">*</span></label>
                                    <div class="controls">
                                        <select name="txt_local_team" id="txt_local_team" class="form-control">
                                            <option class="form-control">-Select-</option>
                                            <?php foreach($teams as $team)
                                            { ?>
                                                <option value="<?php echo $team['tm_id']; ?>" class="form-control"><?php echo $team['tm_name']; ?></option>
                                            <?php } ?>
										</select>
                                    </div>
                                </div>

                                <!-- Drop down -->
                                <div class="control-group ">
                                    <label class="control-label" for="txt_visitor_team">Visitor Team<span class="text-danger">*</span></label>
                                    <div class="controls">
                                        <select name="txt_visitor_team" id="txt_visitor_team" class="form-control">
                                            <option class="form-control">-Select-</option>
                                            <?php foreach($teams as $team)
                                            { ?>
                                                <option value="<?php echo $team['tm_id']; ?>" class="form-control"><?php echo $team['tm_name']; ?></option>
                                            <?php } ?>
                                    </select>
                                    </div>
                                </div>

                                <!-- Text input-->
                                <div class="control-group ">
                                    <label class="control-label" for="sel_venue">Venue<span class="text-danger">*</span></label>
                                    <div class="controls">
										<select name="sel_venue" id="sel_venue" class="form-control">
                                            <option value="" class="form-control">-Select-</option>
                                            <?php foreach($venues as $venue)
                                            { ?>
                                                <option value="<?php echo $venue['ven_name']; ?>" class="form-control"><?php echo $venue['ven_name']; ?></option>
                                            <?php } ?>
										</select>
                                    </div>
                                </div>

                                <!-- Text input-->
                                <div class="control-group ">
                                    <label class="control-label" for="txt_match_date">Match start on<span class="text-danger">*</span></label>
                                    <div class="controls">
                                        <input id="txt_match_date" name="txt_match_date"  class="form-control" value="2023-05-0 18:00:00" type="text">
                                    </div>

                                </div>

                                <!-- Text input-->
                                <div class="control-group ">
                                    <label class="control-label" for="txt_score">Score<span class="text-danger">*</span></label>
                                    <div class="controls">
										<select name="sel_score" id="sel_score" class="form-control">
                                            <option class="form-control">-Select-</option>
                                            <option value="1" selected class="form-control">1</option>
                                            <option value="3" class="form-control">3</option>
                                            <option value="5" class="form-control">5</option>
										</select>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Save changes</button>
                            <button type="button" class="btn btn-primary" onclick="window.location='<?php echo SITE_URL;?>'">Cancel</button>
                        </div>
                    </form>              </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
    </div>
</main>