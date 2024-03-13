<?php
use App\Repositories\DayRepository;

//transformed reserves to indexed array for easy and optimized use
$indexedReserves = [];
foreach ($reserves as $reserve){
    $index = $reserve['hour_id'] . '_' . $reserve['date'];
    $indexedReserves[$index] = $reserve['user_id'];
}

?>

<?php sectionStart(); ?>
<div class="page-header">
    <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
              <i class="mdi mdi-home"></i>
            </span> Reservation
    </h3>

</div>
<div class="row">
    <div class="col-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>  </th>
                            <?php foreach ($days as $dayKey => $day): ?>
                                <th <?php if($dayKey == 0): ?> class="today" <?php endif; ?> >
                                    <div class="fw-bold fs-5 text-center"><?= substr($day["date"],8,2) ?></div>
                                    <div class="mt-2 text-center"><?= DayRepository::getDayNameByIndex($day["day"]); ?></div>
                                </th>
                            <?php endforeach; ?>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($hours as $hour): ?>
                            <tr>
                                <td><?= $hour['title'] ?></td>
                                <?php foreach ($days as $day): ?>
                                    <?php
                                    $index = $hour['id'] . '_' . $day['date'];
                                    if(!isset($indexedReserves[$index])): ?>
                                        <td class="table-info" role="button" onclick="reserve(<?= $hour["id"] ?>,'<?= $day["date"] ?>');" title="click to reserve">
                                        </td>
                                    <?php elseif(isset($indexedReserves[$index]) && $indexedReserves[$index] == $currentUser): ?>
                                        <td class="table-success" role="button" onclick="reserve(<?= $hour["id"] ?>,'<?= $day["date"] ?>');" title="click to cancel reserve">
                                        </td>
                                    <?php elseif(isset($indexedReserves[$index]) && $indexedReserves[$index] != $currentUser): ?>
                                        <td class="table-danger" title="You can't reserve, booked by another">
                                        </td>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function reserve(hourId, date){
        window.location.href = '/reservations/' + hourId + '/' + date + '/reserve';
    }
</script>
<?php sectionEnd('content'); ?>


<?php layout('panel'); ?>
