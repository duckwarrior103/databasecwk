<?php
	require_once("config.inc.php");

	try {
	    // SQL query to create a new table named "new_table"
	    $sql = "CREATE TABLE NameEntry (
			NameEntryID INT PRIMARY KEY AUTO_INCREMENT,
			FirstName VARCHAR(50) NOT NULL,
			MiddleName VARCHAR(50) DEFAULT '',
			LastName VARCHAR(50),
			PreferredName VARCHAR(50) DEFAULT ''
		);
		
		-- Table for City Lookup
		CREATE TABLE CityLookUp (
			CityName VARCHAR(50) PRIMARY KEY,
			County VARCHAR(50),
			Country VARCHAR(50)
		);

		CREATE TABLE Location (
			LocationID INT PRIMARY KEY AUTO_INCREMENT,
			StreetName VARCHAR(50) NOT NULL,
			PostCode VARCHAR(10) NOT NULL,
			CityName VARCHAR(50) NOT NULL,
			FOREIGN KEY (CityName) REFERENCES CityLookUp(CityName)
		);
		
		CREATE TABLE Area (
			AreaID INT PRIMARY KEY AUTO_INCREMENT,
			AreaName VARCHAR(50) NOT NULL UNIQUE,
			LocationID INT,
			FOREIGN KEY (LocationID) REFERENCES Location(LocationID)
		);
		
		CREATE TABLE Building (
			BuildingID INT PRIMARY KEY AUTO_INCREMENT,
			AreaID INT,
			LocationID INT,
			FOREIGN KEY (AreaID) REFERENCES Area(AreaID),
			FOREIGN KEY (LocationID) REFERENCES Location(LocationID)
		);

		CREATE TABLE Department (
			DepartmentID INT PRIMARY KEY AUTO_INCREMENT,
			Name VARCHAR(50),
			TotalEmployees INT,
			LocationID INT NOT NULL,
			FOREIGN KEY (LocationID) REFERENCES Location(LocationID)
		);
		
		CREATE TABLE EmergencyContactEntry (
			EmergencyEntryID INT PRIMARY KEY AUTO_INCREMENT,
			NameEntryID INT NOT NULL,
			Relationship VARCHAR(30) NOT NULL,
			PhoneNumber VARCHAR(20) NOT NULL,
			FOREIGN KEY (NameEntryID) REFERENCES NameEntry(NameEntryID)
		);

		CREATE TABLE Employee (
			EmployeeID INT PRIMARY KEY,
			NameEntryID INT NOT NULL,
			LocationID INT NOT NULL,
			Salary INT NOT NULL,
			DateOfBirth DATE NOT NULL,
			NIN VARCHAR(20) NOT NULL,
			DepartmentID INT NOT NULL,
			ManagerID INT, -- Self-referencing foreign key
			EmergencyEntryID INT NOT NULL,
			FOREIGN KEY (NameEntryID) REFERENCES NameEntry(NameEntryID),
			FOREIGN KEY (LocationID) REFERENCES Location(LocationID),
			FOREIGN KEY (DepartmentID) REFERENCES Department(DepartmentID),
			FOREIGN KEY (ManagerID) REFERENCES Employee(EmployeeID),
			FOREIGN KEY (EmergencyEntryID) REFERENCES EmergencyContactEntry(EmergencyEntryID)
		);

	
		
		CREATE TABLE HRstaff (
			EmployeeID INT PRIMARY KEY,
			FOREIGN KEY (EmployeeID) REFERENCES Employee(EmployeeID)
		);
		
		CREATE TABLE Packager (
			EmployeeID INT PRIMARY KEY,
			DepartmentID INT NOT NULL,
			AreaID INT NOT NULL,
			FOREIGN KEY (EmployeeID) REFERENCES Employee(EmployeeID),
			FOREIGN KEY (DepartmentID) REFERENCES Department(DepartmentID),
			FOREIGN KEY (AreaID) REFERENCES Area(AreaID)
		);
		
		CREATE TABLE Vehicle (
			VehicleID INT PRIMARY KEY AUTO_INCREMENT,
			Name VARCHAR(50) NOT NULL,
			AreaID INT NOT NULL,
			FOREIGN KEY (AreaID) REFERENCES Area(AreaID)
		);
		CREATE TABLE Stop (
			StopID INT PRIMARY KEY AUTO_INCREMENT,
			ArrivalTime TIMESTAMP NOT NULL,
			LeavingTime TIMESTAMP NOT NULL,
			LocationID INT NOT NULL,
			FOREIGN KEY (LocationID) REFERENCES Location(LocationID)
		);
		
		CREATE TABLE Route (
			RouteID VARCHAR(20) PRIMARY KEY,
			StartID INT NOT NULL,
			EndID INT,
			StartTime TIMESTAMP NOT NULL,
			EndTime TIMESTAMP NOT NULL,
			FOREIGN KEY (StartID) REFERENCES Stop(LocationID),
			FOREIGN KEY (EndID) REFERENCES Stop(LocationID)
		);
		
		
		
		CREATE TABLE RouteStopJunction (
			StopID INT,
			RouteID VARCHAR(20),
			PRIMARY KEY (StopID, RouteID),
			FOREIGN KEY (StopID) REFERENCES Stop(StopID),
			FOREIGN KEY (RouteID) REFERENCES Route(RouteID)
		);
		CREATE TABLE Driver (
			EmployeeID INT PRIMARY KEY,
			WorkingHours INT NOT NULL,
			VehicleID INT,
			RouteID VARCHAR(20),
			FOREIGN KEY (EmployeeID) REFERENCES Employee(EmployeeID),
			FOREIGN KEY (DepartmentID) REFERENCES Department(DepartmentID),
			FOREIGN KEY (VehicleID) REFERENCES Vehicle(VehicleID),
			FOREIGN KEY (RouteID) REFERENCES Route(RouteID)
		);

		CREATE TABLE Office (
			OfficeID INT PRIMARY KEY AUTO_INCREMENT,
			Name VARCHAR(50) NOT NULL,
			BuildingID INT,
			FOREIGN KEY (BuildingID) REFERENCES Building(BuildingID)
		);
		
		-- Tables for Warehouse, Vehicle, Route, and Stops
		CREATE TABLE Warehouse (
			WarehouseID INT PRIMARY KEY AUTO_INCREMENT,
			Size INT DEFAULT 0,
			Purpose INT DEFAULT NULL,
			BuildingID INT NOT NULL,
			FOREIGN KEY (BuildingID) REFERENCES Building(BuildingID)
		);

		
		CREATE TABLE Customer (
			CustomerID INT PRIMARY KEY AUTO_INCREMENT,
			NameEntryID INT,
			LocationID INT NOT NULL,
			EmailAddress VARCHAR(100) NOT NULL,
			FOREIGN KEY (NameEntryID) REFERENCES NameEntry(NameEntryID),
			FOREIGN KEY (LocationID) REFERENCES Location(LocationID)
		);


		-- Table for Products
		CREATE TABLE Product (
			ProductID INT PRIMARY KEY AUTO_INCREMENT,
			Name VARCHAR(20),
			Description VARCHAR(50) DEFAULT 'N/A',
			Price INT NOT NULL
		);

		-- -- Tables for Customer and Order Information
		
		
		
		
		-- Table for Warehouse-Product Junction
		CREATE TABLE WarehouseProductJunction (
			ProductID INT,
			WarehouseID INT,
			Quantity INT DEFAULT 0,
			PRIMARY KEY (ProductID, WarehouseID),
			FOREIGN KEY (ProductID) REFERENCES Product(ProductID),
			FOREIGN KEY (WarehouseID) REFERENCES Warehouse(WarehouseID)
		);

		CREATE TABLE `Order` (
			OrderID INT PRIMARY KEY AUTO_INCREMENT,
			CustomerID INT NOT NULL,
			PurchaseDate DATE NOT NULL,
			FOREIGN KEY (CustomerID) REFERENCES Customer(CustomerID) 
		);


		CREATE TABLE OrderProductJunction (
			OrderID INT NOT NULL,
			ProductID INT NOT NULL,
			Quantity INT DEFAULT 0,
			PRIMARY KEY (OrderID, ProductID),
			FOREIGN KEY (OrderID) REFERENCES `Order`(OrderID),
			FOREIGN KEY (ProductID) REFERENCES Product(ProductID)
		);
		
		-- Tables for Complaints and Office Information
		CREATE TABLE Complaint (
			ComplaintID INT PRIMARY KEY AUTO_INCREMENT,
			CustomerID INT NOT NULL,
			Reason VARCHAR(200),
			Status VARCHAR(20) DEFAULT 'Processing',
			OrderID INT NOT NULL,
			EmployeeID INT NOT NULL,
			FOREIGN KEY (CustomerID) REFERENCES Customer(CustomerID),
			FOREIGN KEY (OrderID) REFERENCES `Order`(OrderID),
			FOREIGN KEY (EmployeeID) REFERENCES Employee(EmployeeID)
		);
		
		CREATE TABLE Auditing (
			EmployeeID INT PRIMARY KEY,
			FOREIGN KEY (EmployeeID) REFERENCES Employee(EmployeeID)
			
		);
		
		
		
		
		";

	    // Use the exec() method to execute the query
	    $conn->exec($sql);

	    echo "Table 'new_table' created successfully";
	} catch (PDOException $e) {
	    echo "Error creating table: " . $e->getMessage();
	}


	// Close the database connection
	$conn = null;
?>	