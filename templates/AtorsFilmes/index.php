<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AtorsFilme[]|\Cake\Collection\CollectionInterface $atorsFilmes
 */
?>
<div class="atorsFilmes index content">
    <?= $this->Html->link(__('New Ators Filme'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Ators Filmes') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('filme_id') ?></th>
                    <th><?= $this->Paginator->sort('ator_id') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($atorsFilmes as $atorsFilme): ?>
                <tr>
                    <td><?= $this->Number->format($atorsFilme->id) ?></td>
                    <td><?= $atorsFilme->has('filme') ? $this->Html->link($atorsFilme->filme->id, ['controller' => 'Filmes', 'action' => 'view', $atorsFilme->filme->id]) : '' ?></td>
                    <td><?= $atorsFilme->has('ator') ? $this->Html->link($atorsFilme->ator->id, ['controller' => 'Ators', 'action' => 'view', $atorsFilme->ator->id]) : '' ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $atorsFilme->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $atorsFilme->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $atorsFilme->id], ['confirm' => __('Are you sure you want to delete # {0}?', $atorsFilme->id)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>
