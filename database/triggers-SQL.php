<?php 
//triggers

//1) ACTUALIZAR EL STOCK DE PRODUCTOS COMPRADOS

DELIMITER //
CREATE TRIGGER tr_updStockPurchase AFTER INSERT ON detailpurchases
	FOR EACH ROW BEGIN
	UPDATE products SET stock = stock + NEW.quantity
	WHERE products.id = NEW.product_id;
END
//
DELIMITER ;

/*2) Actualizar el stock para productos devueltos*/

DELIMITER //
CREATE TRIGGER tr_updStockPurchaseNull AFTER UPDATE ON purchases
	FOR EACH ROW BEGIN
	UPDATE products p
	JOIN detailpurchases dp
	ON dp.product_id = p.id
	AND dp.purchase_id = NEW.id
	SET p.stock = p.stock - dp.quantity;
END;
//
DELIMITER ;

// 3) VENTAS: actualizar stock despues de una venta

DELIMITER //
CREATE TRIGGER tr_updStockSale AFTER INSERT ON detailsales 
	FOR EACH ROW BEGIN
    UPDATE products SET stock = stock - NEW.quantity
    WHERE products.id = NEW.product_id;
END
//
DELIMITER ;

// 4) Ventas: Reponer stock despues de anular una venta

DELIMITER //
CREATE TRIGGER tr_updStockSaleNull AFTER UPDATE ON sales FOR EACH ROW
BEGIN
	UPDATE products a
    JOIN detailsales ds
    ON ds.product_id = a.id
    AND ds.sale_id = NEW.id
    SET a.stock = a.stock + ds.quantity;
END;
//
DELIMITER ;

 ?>