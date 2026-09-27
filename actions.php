<?php
session_start();
require_once 'db.php';
require_once 'auth.php';

header('Content-Type: application/json');

$action = $_GET['action'] ?? '';
$input = json_decode(file_get_contents('php://input'), true) ?? [];

switch ($action) {
    case 'login':
        echo json_encode(handleLogin($pdo, $input));
        break;

    case 'register':
        echo json_encode(handleRegistration($pdo, $input));
        break;

    case 'logout':
        echo json_encode(handleLogout());
        break;

    case 'get_dashboard_data':
        echo json_encode(getDashboardData($pdo));
        break;

    case 'add_vehicle':
        echo json_encode(addVehicle($pdo, $input));
        break;

    case 'book_appointment':
        echo json_encode(bookAppointment($pdo, $input));
        break;

    case 'assign_mechanic':
        echo json_encode(assignMechanic($pdo, $input));
        break;

    case 'update_mechanic_task':
        echo json_encode(updateMechanicTask($pdo, $input));
        break;

    case 'add_spare_part':
        echo json_encode(addSparePart($pdo, $input));
        break;

    case 'update_spare_part':
        echo json_encode(updateSparePart($pdo, $input));
        break;

    case 'delete_record':
        echo json_encode(deleteRecord($pdo, $input));
        break;

    default:
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
        break;
}

// FUNCTION DEFINITIONS

function getDashboardData(PDO $pdo): array {
    if (!isset($_SESSION['user'])) {
        return ['success' => false, 'message' => 'Unauthorized'];
    }

    return [
        'success' => true,
        'currentUser' => $_SESSION['user'],
        'users' => $pdo->query("SELECT id, name, email, phone, role, specialty, branch FROM users")->fetchAll(),
        'vehicles' => $pdo->query("SELECT * FROM vehicles")->fetchAll(),
        'appointments' => $pdo->query("SELECT * FROM appointments")->fetchAll(),
        'serviceRecords' => $pdo->query("SELECT * FROM service_records")->fetchAll(),
        'spareParts' => $pdo->query("SELECT * FROM spare_parts")->fetchAll()
    ];
}

function addVehicle(PDO $pdo, array $data): array {
    $stmt = $pdo->prepare("INSERT INTO vehicles (plate, brand_model, mileage, vin, owner_email, health_score) VALUES (?, ?, ?, ?, ?, 92)");
    $stmt->execute([$data['plate'], $data['brandModel'], $data['mileage'], $data['vin'], $_SESSION['user']['email']]);
    return ['success' => true];
}

function bookAppointment(PDO $pdo, array $data): array {
    $stmt = $pdo->prepare("INSERT INTO appointments (customer_email, customer_name, vehicle_plate, service, appointment_date, status) VALUES (?, ?, ?, ?, ?, 'Pending')");
    $stmt->execute([$_SESSION['user']['email'], $_SESSION['user']['name'], $data['vehiclePlate'], $data['service'], $data['date']]);
    return ['success' => true];
}

function assignMechanic(PDO $pdo, array $data): array {
    $stmt = $pdo->prepare("UPDATE appointments SET mechanic_email = ?, status = 'In Progress' WHERE id = ?");
    $stmt->execute([$data['mechanicEmail'], $data['aptId']]);
    return ['success' => true];
}

function updateMechanicTask(PDO $pdo, array $data): array {
    $stmt = $pdo->prepare("UPDATE appointments SET status = ? WHERE id = ?");
    $stmt->execute([$data['status'], $data['taskId']]);

    if ($data['status'] === 'Completed') {
        $partsCost = 0;

        // Process multiple spare parts if array supplied
        if (!empty($data['partsUsed']) && is_array($data['partsUsed'])) {
            $stmtPart = $pdo->prepare("SELECT unit_price FROM spare_parts WHERE id = ?");
            $stmtStock = $pdo->prepare("UPDATE spare_parts SET qty = GREATEST(0, qty - ?) WHERE id = ?");

            foreach ($data['partsUsed'] as $item) {
                $partId = intval($item['partId'] ?? 0);
                $qty = intval($item['quantity'] ?? 1);

                if ($partId > 0 && $qty > 0) {
                    // Deduct inventory stock
                    $stmtStock->execute([$qty, $partId]);

                    // Calculate part cost
                    $stmtPart->execute([$partId]);
                    $part = $stmtPart->fetch();
                    if ($part) {
                        $partsCost += ($part['unit_price'] * $qty);
                    }
                }
            }
        }

        $stmtApt = $pdo->prepare("SELECT * FROM appointments WHERE id = ?");
        $stmtApt->execute([$data['taskId']]);
        $apt = $stmtApt->fetch();

        $cost = $partsCost > 0 ? ($partsCost + 120) : 250;
        $today = date('Y-m-d');

        $stmtRec = $pdo->prepare("INSERT INTO service_records (record_date, vehicle_plate, service, mileage, notes, cost, status) VALUES (?, ?, ?, 65000, ?, ?, 'Completed')");
        $stmtRec->execute([$today, $apt['vehicle_plate'], $apt['service'], $data['notes'] ?: 'Service completed.', $cost]);

        $pdo->prepare("UPDATE vehicles SET health_score = LEAST(100, health_score + 15) WHERE plate = ?")->execute([$apt['vehicle_plate']]);
    }

    return ['success' => true];
}

function addSparePart(PDO $pdo, array $data): array {
    $stmt = $pdo->prepare("INSERT INTO spare_parts (name, qty, unit_price) VALUES (?, ?, ?)");
    $stmt->execute([$data['name'], $data['qty'], $data['unitPrice']]);
    return ['success' => true];
}

function updateSparePart(PDO $pdo, array $data): array {
    $stmt = $pdo->prepare("UPDATE spare_parts SET qty = ?, unit_price = ? WHERE id = ?");
    $stmt->execute([$data['qty'], $data['unitPrice'], $data['id']]);
    return ['success' => true];
}

function deleteRecord(PDO $pdo, array $data): array {
    $table = $data['table'];
    $id = $data['id'];
    $allowed = ['users', 'vehicles', 'appointments', 'spareParts'];
    
    if (in_array($table, $allowed)) {
        $stmt = $pdo->prepare("DELETE FROM $table WHERE id = ?");
        $stmt->execute([$id]);
        return ['success' => true];
    }

    return ['success' => false, 'message' => 'Invalid table selection'];
}
?>