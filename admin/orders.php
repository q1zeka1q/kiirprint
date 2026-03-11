<?php
session_start();
require_once '../includes/config.php';

// Проверка авторизации
if (!isset($_SESSION['logged_in'])) { header("Location: login.php"); exit; }

// Удаление заказа
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM orders WHERE id = $id");
    header("Location: admin.php?page=orders&success=deleted");
    exit;
}

// Получаем список заказов (самые свежие сверху)
$sql = "SELECT o.*, s.title as service_name 
        FROM orders o 
        LEFT JOIN services s ON o.service_id = s.id 
        ORDER BY o.order_date DESC";
$res = $conn->query($sql);
?>

<div class="orders-container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <h2><i class="fas fa-shopping-cart"></i> Uued Tellimused</h2>
        <span style="background: #f36f21; color: white; padding: 5px 15px; border-radius: 20px; font-size: 14px;">
            Kokku: <?= $res->num_rows ?> tellimust
        </span>
    </div>

    <?php if ($res->num_rows > 0): ?>
        <div class="table-responsive">
            <table class="orders-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Kuupäev</th>
                        <th>Toode</th>
                        <th>Kogus / Paber</th>
                        <th>Hind</th>
                        <th>Klient</th>
                        <th>Kontakt</th>
                        <th>Tegevus</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($o = $res->fetch_assoc()): ?>
                        <tr>
                            <td>#<?= $o['id'] ?></td>
                            <td><?= date('d.m.Y H:i', strtotime($o['order_date'])) ?></td>
                            <td style="font-weight: bold; color: #333;"><?= htmlspecialchars($o['service_name']) ?></td>
                            <td>
                                <span class="badge-info"><?= $o['quantity'] ?> tk</span><br>
                                <small style="color: #888;"><?= htmlspecialchars($o['paper_type']) ?></small>
                            </td>
                            <td style="font-weight: 800; color: #f36f21;"><?= number_format($o['total_price'], 2) ?> €</td>
                            <td>
                                <strong><?= htmlspecialchars($o['client_name']) ?></strong>
                            </td>
                            <td>
                                <i class="fas fa-envelope"></i> <?= htmlspecialchars($o['client_email']) ?><br>
                                <i class="fas fa-phone"></i> <?= htmlspecialchars($o['client_phone']) ?>
                            </td>
                            <td>
                                <a href="admin.php?page=orders&delete=<?= $o['id'] ?>" 
                                   onclick="return confirm('Kas oled kindel, et soovid tellimuse kustutada?')" 
                                   class="btn-delete">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </td>
                        </tr>
                        <?php if(!empty($o['client_message'])): ?>
                            <tr class="message-row">
                                <td colspan="8">
                                    <strong>Lisainfo:</strong> <?= htmlspecialchars($o['client_message']) ?>
                                </td>
                            </tr>
                        <?php endif; ?>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div style="text-align: center; padding: 50px; background: white; border-radius: 12px;">
            <i class="fas fa-box-open" style="font-size: 50px; color: #ddd; margin-bottom: 20px;"></i>
            <p style="color: #999;">Tellimusi veel ei ole.</p>
        </div>
    <?php endif; ?>
</div>

<style>
.orders-table { width: 100%; border-collapse: collapse; background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.05); }
.orders-table th { background: #f8f9fa; padding: 15px; text-align: left; color: #666; font-size: 13px; text-transform: uppercase; }
.orders-table td { padding: 15px; border-bottom: 1px solid #eee; vertical-align: middle; font-size: 14px; }
.badge-info { background: #eef2f7; padding: 2px 8px; border-radius: 4px; font-size: 12px; font-weight: bold; }
.btn-delete { color: #dc3545; padding: 8px; border-radius: 4px; transition: 0.3s; }
.btn-delete:hover { background: #fff1f2; color: #a71d2a; }
.message-row td { background: #fffcf5; padding: 10px 15px; border-bottom: 2px solid #eee; font-style: italic; font-size: 13px; color: #666; }
.table-responsive { overflow-x: auto; }
</style>