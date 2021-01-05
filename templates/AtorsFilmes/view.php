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
            <?= $this->Html->link(__('Edit Ators Filme'), ['action' => 'edit', $atorsFilme->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Ators Filme'), ['action' => 'delete', $atorsFilme->id], ['confirm' => __('Are you sure you want to delete # {0}?', $atorsFilme->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Ators Filmes'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Ators Filme'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="atorsFilmes view content">
            <h3><?= h($atorsFilme->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Filme') ?></th>
                    <td><?= $atorsFilme->has('filme') ? $this->Html->link($atorsFilme->filme->id, ['controller' => 'Filmes', 'action' => 'view', $atorsFilme->filme->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Ator') ?></th>
                    <td><?= $atorsFilme->has('ator') ? $this->Html->link($atorsFilme->ator->id, ['controller' => 'Ators', 'action' => 'view', $atorsFilme->ator->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($atorsFilme->id) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
