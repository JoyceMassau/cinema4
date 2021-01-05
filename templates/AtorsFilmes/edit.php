<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AtorsFilme $atorsFilme
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $atorsFilme->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $atorsFilme->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Ators Filmes'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="atorsFilmes form content">
            <?= $this->Form->create($atorsFilme) ?>
            <fieldset>
                <legend><?= __('Edit Ators Filme') ?></legend>
                <?php
                    echo $this->Form->control('filme_id', ['options' => $filmes, 'empty' => true]);
                    echo $this->Form->control('ator_id', ['options' => $ators, 'empty' => true]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
