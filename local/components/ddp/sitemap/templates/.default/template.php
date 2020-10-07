<div class="content">
	<ul class="site-map">
		<?php $depth = 1 ?>
		<?php foreach ($arResult['ITEMS'] as $item) { ?>
            <?php if ($item['DEPTH'] > $depth) { ?>
                <ul>
            <?php } elseif ($item['DEPTH'] < $depth) { ?>
                <?php do { ?>
                </ul></li>
                <?php } while (--$depth > $item['DEPTH']); ?>
            <?php } else { ?>
                </li>
            <?php } ?>
			<li class="depth-<?= count(explode('/', trim($item['LINK'], '/'))) ?>">
				<a href="<?= $item['LINK'] ?>"><?= $item['NAME'] ?></a>
            <?php $depth = $item['DEPTH']; ?>
		<?php } ?>
            </li>
	</ul>
</div>
