<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historia Clínica - Sistema de Salud</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            padding: 20px;
        }
        
        .app-wrapper {
            max-width: 1200px;
            margin: 0 auto;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        .header {
            background: linear-gradient(135deg, #003d82 0%, #005eb8 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        
        .header h1 {
            font-size: 28px;
            margin-bottom: 5px;
        }
        
        .header p {
            font-size: 14px;
            opacity: 0.9;
        }
        
        .tabs-container {
            display: flex;
            border-bottom: 2px solid #e0e0e0;
            background-color: #f9f9f9;
            overflow-x: auto;
        }
        
        .tab-button {
            flex: 1;
            padding: 16px 20px;
            border: none;
            background: none;
            cursor: pointer;
            font-size: 15px;
            font-weight: 500;
            color: #666;
            border-bottom: 3px solid transparent;
            transition: all 0.3s;
            min-width: 150px;
            white-space: nowrap;
        }
        
        .tab-button:hover {
            background-color: #f0f0f0;
        }
        
        .tab-button.active {
            color: #003d82;
            border-bottom-color: #003d82;
        }
        
        .tab-button.completed {
            color: #4caf50;
        }
        
        .content {
            display: flex;
        }
        
        .tab-content {
            flex: 1;
            padding: 40px;
            display: none;
            animation: fadeIn 0.3s;
        }
        
        .tab-content.active {
            display: block;
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }
        
        .form-group {
            display: flex;
            flex-direction: column;
        }
        
        label {
            font-weight: bold;
            margin-bottom: 8px;
            color: #333;
            font-size: 14px;
        }
        
        input[type="text"],
        input[type="email"],
        input[type="tel"],
        input[type="date"],
        input[type="number"],
        input[type="time"],
        select,
        textarea {
            padding: 10px 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
            font-family: Arial, sans-serif;
        }
        
        input:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: #003d82;
            box-shadow: 0 0 5px rgba(0,61,130,0.2);
        }
        
        textarea {
            resize: vertical;
            min-height: 80px;
        }
        
        .checkbox-group {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            margin-top: 8px;
        }
        
        .checkbox-item {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .checkbox-item input[type="checkbox"],
        .checkbox-item input[type="radio"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
        }
        
        .checkbox-item label {
            margin-bottom: 0;
            font-weight: normal;
        }
        
        .section-title {
            background-color: #f0f0f0;
            border-left: 4px solid #003d82;
            padding: 15px;
            margin: 25px 0 20px 0;
            font-weight: bold;
            color: #003d82;
        }
        
        .signature-canvas {
            border: 2px solid #ccc;
            border-radius: 4px;
            cursor: crosshair;
            background-color: #fff;
            display: block;
            margin-top: 10px;
            touch-action: none;
        }
        
        .signature-buttons {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }
        
        .signature-buttons button {
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 13px;
            font-weight: bold;
        }
        
        .btn-clear-sig {
            background-color: #f44336;
            color: white;
        }
        
        .btn-clear-sig:hover {
            background-color: #da190b;
        }
        
        .btn-save-sig {
            background-color: #4caf50;
            color: white;
        }
        
        .btn-save-sig:hover {
            background-color: #45a049;
        }
        
        .signature-preview {
            margin-top: 10px;
            text-align: center;
        }
        
        .signature-preview img {
            max-width: 200px;
            border: 1px solid #ddd;
            border-radius: 4px;
            display: none;
        }
        
        .signature-preview img.saved {
            display: block;
        }
        
        .navigation {
            display: flex;
            justify-content: space-between;
            padding: 30px 40px 40px;
            gap: 20px;
        }
        
        button {
            padding: 12px 30px;
            font-size: 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        
        .btn-prev {
            background-color: #999;
            color: white;
        }
        
        .btn-prev:hover:not(:disabled) {
            background-color: #777;
        }
        
        .btn-next {
            background-color: #003d82;
            color: white;
        }
        
        .btn-next:hover {
            background-color: #002a5a;
        }
        
        .btn-submit {
            background-color: #4caf50;
            color: white;
        }
        
        .btn-submit:hover {
            background-color: #45a049;
        }
        
        button:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        
        .response-box {
            background-color: #f0f8ff;
            border: 2px solid #003d82;
            padding: 20px 40px;
            margin-bottom: 20px;
            border-radius: 4px;
            display: none;
        }
        
        .response-box.show {
            display: block;
        }
        
        .response-box h3 {
            color: #003d82;
            margin-bottom: 10px;
        }
        
        .response-box pre {
            background-color: #f5f5f5;
            padding: 15px;
            border-radius: 4px;
            overflow-x: auto;
            font-size: 12px;
            max-height: 300px;
            overflow-y: auto;
        }
        
        .success {
            background-color: #d4edda;
            color: #155724;
            padding: 15px 40px;
            border-radius: 4px;
            margin: 20px 40px 0;
            display: none;
            border-left: 4px solid #155724;
        }
        
        .success.show {
            display: block;
        }
        
        .btn-pdf {
            background-color: #d32f2f;
            color: white;
        }
        
        .btn-pdf:hover {
            background-color: #b71c1c;
        }
        
        .info-box {
            background-color: #e8f4f8;
            border-left: 4px solid #007bff;
            padding: 15px;
            margin: 20px 0;
            font-size: 14px;
        }
        
        .table-grid {
            display: grid;
            grid-template-columns: repeat(8, 1fr);
            gap: 10px;
            margin-bottom: 20px;
        }
        
        .table-header {
            background-color: #003d82;
            color: white;
            padding: 10px;
            text-align: center;
            font-weight: bold;
            font-size: 12px;
        }
        
        .table-cell {
            padding: 10px;
            border: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <div class="app-wrapper">
        <div class="header">
            <h1>📋 HISTORIA CLÍNICA</h1>
            <p>Sistema de Registro de Pacientes - ED Salud</p>
        </div>
        
        <div class="tabs-container">
            <button class="tab-button active" data-tab="0">👤 Datos del Paciente</button>
            <button class="tab-button" data-tab="1">🚑 Causa Atención</button>
            <button class="tab-button" data-tab="2">📝 Antecedentes</button>
            <button class="tab-button" data-tab="3">🌡️ Signos Vitales</button>
            <button class="tab-button" data-tab="4">🔍 Examen</button>
            <button class="tab-button" data-tab="5">⚠️ Diagnóstico</button>
            <button class="tab-button" data-tab="6">🚑 Procedimientos</button>
            <button class="tab-button" data-tab="7">✍️ Firmas</button>
        </div>
        
        <form id="clinicalForm">
            <div class="content">
                <!-- TAB 0: DATOS DEL PACIENTE -->
                <div class="tab-content active" data-tab="0">
                    <div class="section-title">Información Personal</div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="fullName">Nombre Completo *</label>
                            <input type="text" id="fullName" name="fullName" required>
                        </div>
                        <div class="form-group">
                            <label for="documentType">Tipo de Documento *</label>
                            <select id="documentType" name="documentType" required>
                                <option value="">Seleccione</option>
                                <option value="CC">Cédula de Ciudadanía</option>
                                <option value="TI">Tarjeta de Identidad</option>
                                <option value="CE">Cédula de Extranjería</option>
                                <option value="RC">Registro Civil</option>
                                <option value="PA">Pasaporte</option>
                                <option value="MS">Menor sin Identificación</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="documentId">Número de Documento *</label>
                            <input type="text" id="documentId" name="documentId" required>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="birthDate">Fecha de Nacimiento *</label>
                            <input type="date" id="birthDate" name="birthDate" required>
                        </div>
                        <div class="form-group">
                            <label for="age">Edad</label>
                            <input type="number" id="age" name="age" readonly>
                        </div>
                        <div class="form-group">
                            <label for="gender">Género</label>
                            <select id="gender" name="gender">
                                <option value="">Seleccione</option>
                                <option value="M">Masculino</option>
                                <option value="F">Femenino</option>
                                <option value="O">Otro</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="address">Dirección</label>
                            <input type="text" id="address" name="address">
                        </div>
                        <div class="form-group">
                            <label for="city">Ciudad</label>
                            <input type="text" id="city" name="city">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="phone">Teléfono 1</label>
                            <input type="tel" id="phone" name="phone">
                        </div>
                        <div class="form-group">
                            <label for="email">Correo Electrónico</label>
                            <input type="email" id="email" name="email">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="patientRepresentative">Acudiente del paciente</label>
                            <input type="text" id="patientRepresentative" name="patientRepresentative">
                        </div>
                        <div class="form-group">
                            <label for="eps">EPS</label>
                            <input type="text" id="eps" name="eps">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="policyNumber">Número de Póliza</label>
                            <input type="text" id="policyNumber" name="policyNumber">
                        </div>
                        <div class="form-group">
                            <label for="policyExpiration">Fecha de Vencimiento</label>
                            <input type="date" id="policyExpiration" name="policyExpiration">
                        </div>
                    </div>
                </div>
                
                <!-- TAB 1: CAUSA ATENCIÓN -->
                <div class="tab-content" data-tab="1">
                    <div class="section-title">Información de la Consulta</div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="consultDate">Fecha de Consulta *</label>
                            <input type="date" id="consultDate" name="consultDate" required>
                        </div>
                        <div class="form-group">
                            <label for="consultTime">Hora de Consulta</label>
                            <input type="time" id="consultTime" name="consultTime">
                        </div>
                    </div>
                    
                    <div class="section-title">Causa que origina la atención</div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="conductor">Conductor</label>
                            <input type="text" id="conductor" name="conductor">
                        </div>
                        <div class="form-group">
                            <label for="occupant">Ocupante</label>
                            <input type="text" id="occupant" name="occupant">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="vehiclePlate">Placa Vehículo</label>
                            <input type="text" id="vehiclePlate" name="vehiclePlate">
                        </div>
                        <div class="form-group">
                            <label for="kinematics">Cinemática</label>
                            <input type="text" id="kinematics" name="kinematics">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="pedestrian">Peatón</label>
                            <select id="pedestrian" name="pedestrian">
                                <option value="">Seleccione</option>
                                <option value="SI">Sí</option>
                                <option value="NO">No</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="cyclist">Ciclista</label>
                            <select id="cyclist" name="cyclist">
                                <option value="">Seleccione</option>
                                <option value="SI">Sí</option>
                                <option value="NO">No</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <!-- TAB 2: ANTECEDENTES -->
                <div class="tab-content" data-tab="2">
                    <div class="section-title">Antecedentes Personales</div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="allergies">Alergias</label>
                            <textarea id="allergies" name="allergies"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="recentSurgeries">CX: Recientes</label>
                            <textarea id="recentSurgeries" name="recentSurgeries" placeholder="Cirugías recientes"></textarea>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="fum">F.U.M (Fecha Última Menstruación)</label>
                            <input type="date" id="fum" name="fum">
                        </div>
                        <div class="form-group">
                            <label for="currentMedications">Medicamentos</label>
                            <textarea id="currentMedications" name="currentMedications"></textarea>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="diseaseHistory">Antecedentes de Enfermedades</label>
                        <textarea id="diseaseHistory" name="diseaseHistory"></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="clinicalOrigin">Origen Clínico</label>
                        <textarea id="clinicalOrigin" name="clinicalOrigin"></textarea>
                    </div>
                </div>
                
                <!-- TAB 3: SIGNOS VITALES -->
                <div class="tab-content" data-tab="3">
                    <div class="section-title">Signos Vitales</div>
                    
                    <div class="info-box">
                        <strong>Nota:</strong> Complete la tabla con los signos vitales del paciente. Puede agregar múltiples registros en diferentes horarios si es necesario.
                    </div>
                    
                    <div class="table-grid">
                        <div class="table-header">HORA</div>
                        <div class="table-header">T.A (mmHg)</div>
                        <div class="table-header">F.C (lat/min)</div>
                        <div class="table-header">F.R (resp/min)</div>
                        <div class="table-header">S.O₂ (%)</div>
                        <div class="table-header">GLUCEMIA (mg/dL)</div>
                        <div class="table-header">TEMPERATURA (°C)</div>
                        <div class="table-header">GLASGOW</div>
                        
                        <div class="table-cell">
                            <input type="time" name="vitalTime[]" style="width: 100%; border: none;">
                        </div>
                        <div class="table-cell">
                            <input type="text" name="bloodPressure[]" placeholder="120/80" style="width: 100%; border: none;">
                        </div>
                        <div class="table-cell">
                            <input type="number" name="heartRate[]" style="width: 100%; border: none;">
                        </div>
                        <div class="table-cell">
                            <input type="number" name="respiratoryRate[]" style="width: 100%; border: none;">
                        </div>
                        <div class="table-cell">
                            <input type="number" name="oxygenSaturation[]" style="width: 100%; border: none;">
                        </div>
                        <div class="table-cell">
                            <input type="number" name="glycemia[]" style="width: 100%; border: none;">
                        </div>
                        <div class="table-cell">
                            <input type="number" name="temperature[]" step="0.1" style="width: 100%; border: none;">
                        </div>
                        <div class="table-cell">
                            <input type="number" name="glasgow[]" min="3" max="15" style="width: 100%; border: none;">
                        </div>
                    </div>
                    
                    <button type="button" onclick="addVitalSignsRow()" style="margin-bottom: 20px; background-color: #4caf50; color: white; padding: 8px 16px; border: none; border-radius: 4px; cursor: pointer;">
                        + Agregar otro registro
                    </button>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="weight">Peso (kg)</label>
                            <input type="number" id="weight" name="weight" step="0.1">
                        </div>
                        <div class="form-group">
                            <label for="height">Altura (cm)</label>
                            <input type="number" id="height" name="height">
                        </div>
                        <div class="form-group">
                            <label for="bmi">IMC</label>
                            <input type="number" id="bmi" name="bmi" readonly step="0.1">
                        </div>
                    </div>
                </div>
                
                <!-- TAB 4: EXAMEN FÍSICO -->
                <div class="tab-content" data-tab="4">
                    <div class="section-title">Descripción de Hallazgos</div>
                    
                    <div class="form-group">
                        <label for="findings">Hallazgos del Examen Físico *</label>
                        <textarea id="findings" name="findings" required rows="6"></textarea>
                    </div>
                </div>
                
                <!-- TAB 5: DIAGNÓSTICO -->
                <div class="tab-content" data-tab="5">
                    <div class="section-title">Clasificación y Diagnóstico</div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>Clasificación Final</label>
                            <div class="checkbox-group">
                                <div class="checkbox-item">
                                    <input type="radio" id="urgencia" name="classification" value="Urgencia">
                                    <label for="urgencia">Urgencia</label>
                                </div>
                                <div class="checkbox-item">
                                    <input type="radio" id="emergencia" name="classification" value="Emergencia">
                                    <label for="emergencia">Emergencia</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="transferType">Tipo de Traslado</label>
                            <select id="transferType" name="transferType">
                                <option value="">Seleccione</option>
                                <option value="AMBULANCIA">Ambulancia</option>
                                <option value="VEHICULO">Vehículo Particular</option>
                                <option value="AEREO">Traslado Aéreo</option>
                                <option value="SIN_TRASLADO">Sin Traslado</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="cupsCode">CÓDIGO CUPS</label>
                            <input type="text" id="cupsCode" name="cupsCode">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="diagnosis">Diagnóstico Clínico</label>
                        <textarea id="diagnosis" name="diagnosis" rows="4"></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="observations">Observaciones Adicionales</label>
                        <textarea id="observations" name="observations" rows="3"></textarea>
                    </div>
                </div>
                
                <!-- TAB 6: PROCEDIMIENTOS -->
                <div class="tab-content" data-tab="6">
                    <div class="section-title">Procedimientos Realizados</div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="immobilization">Inmovilización</label>
                            <textarea id="immobilization" name="immobilization"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="asepsis">Asepsia</label>
                            <textarea id="asepsis" name="asepsis"></textarea>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="cervicalCollar">Collar Cervical</label>
                            <select id="cervicalCollar" name="cervicalCollar">
                                <option value="">Seleccione</option>
                                <option value="SI">Sí</option>
                                <option value="NO">No</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="liquids">Líquido</label>
                            <textarea id="liquids" name="liquids"></textarea>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="medications">Medicamento</label>
                            <textarea id="medications" name="medications"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="otherProcedures">Otros</label>
                            <textarea id="otherProcedures" name="otherProcedures"></textarea>
                        </div>
                    </div>
                    
                    <div class="section-title">Traslado del Paciente</div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>Destino del Traslado</label>
                            <div class="checkbox-group">
                                <div class="checkbox-item">
                                    <input type="radio" id="home" name="destination" value="Casa">
                                    <label for="home">Casa</label>
                                </div>
                                <div class="checkbox-item">
                                    <input type="radio" id="institution" name="destination" value="Institucion">
                                    <label for="institution">Institución de Salud</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="institutionName">Nombre y/o Dirección (Institución)</label>
                            <input type="text" id="institutionName" name="institutionName">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="accidentTime">HORA DEL SINIESTRO</label>
                            <input type="time" id="accidentTime" name="accidentTime">
                        </div>
                        <div class="form-group">
                            <label for="serviceTime">HORARIO DEL SERVICIO</label>
                            <input type="text" id="serviceTime" name="serviceTime" placeholder="Ej: 08:00 - 18:00">
                        </div>
                    </div>
                </div>
                
                <!-- TAB 7: FIRMAS -->
                <div class="tab-content" data-tab="7">
                    <div class="section-title">Firmas Digitales</div>
                    
                    <div class="info-box">
                        <strong>Instrucciones:</strong> Firma en el recuadro correspondiente. Haz clic en "Guardar Firma" para almacenarla.
                    </div>
                    
                    <div class="form-group">
                        <label>Declaración del Paciente o Familiar</label>
                        <div style="border: 1px solid #ddd; padding: 15px; margin: 10px 0; font-style: italic; background-color: #f9f9f9;">
                            "Autorizo mi traslado en el sistema de Emergencia. Me ruego a recibir la atención médica, traslado o internación sugerida por el Sistema de Emergencia Médica, eximo de toda responsabilidad a la empresa de Transporte de Urgencias Médica de las consecuencias que acarreo mi decisión, asumiendo los riesgos que mi negativa pueda generar"
                        </div>
                    </div>
                    
                    <div class="form-group" style="margin-top: 20px;">
                        <label>Firma del Paciente o Familiar</label>
                        <canvas id="patientSignature" class="signature-canvas" width="400" height="150"></canvas>
                        <div class="signature-buttons">
                            <button type="button" class="btn-clear-sig" onclick="clearSignature('patientSignature')">Limpiar</button>
                            <button type="button" class="btn-save-sig" onclick="saveSignature('patientSignature')">Guardar Firma</button>
                        </div>
                        <div class="signature-preview">
                            <img id="patientSignaturePreview" alt="Firma del paciente">
                        </div>
                    </div>
                    
                    <div class="form-row" style="margin-top: 20px;">
                        <div class="form-group">
                            <label for="patientSignatureName">Nombre del Paciente o Familiar</label>
                            <input type="text" id="patientSignatureName" name="patientSignatureName">
                        </div>
                        <div class="form-group">
                            <label for="patientSignatureCC">Cédula</label>
                            <input type="text" id="patientSignatureCC" name="patientSignatureCC">
                        </div>
                    </div>
                    
                    <div style="margin-top: 40px; border-top: 2px solid #003d82; padding-top: 30px;">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="driverName">Conductor</label>
                                <input type="text" id="driverName" name="driverName">
                            </div>
                            <div class="form-group">
                                <label for="paramedicName">Paramedico</label>
                                <input type="text" id="paramedicName" name="paramedicName">
                            </div>
                        </div>
                        
                        <div class="form-group" style="margin-top: 30px;">
                            <label>Firma del Médico que Recibe al Paciente</label>
                            <canvas id="doctorSignature" class="signature-canvas" width="400" height="150"></canvas>
                            <div class="signature-buttons">
                                <button type="button" class="btn-clear-sig" onclick="clearSignature('doctorSignature')">Limpiar</button>
                                <button type="button" class="btn-save-sig" onclick="saveSignature('doctorSignature')">Guardar Firma</button>
                            </div>
                            <div class="signature-preview">
                                <img id="doctorSignaturePreview" alt="Firma del médico">
                            </div>
                        </div>
                        
                        <div class="form-row" style="margin-top: 20px;">
                            <div class="form-group">
                                <label for="doctorCC">Cédula del Médico</label>
                                <input type="text" id="doctorCC" name="doctorCC">
                            </div>
                            <div class="form-group">
                                <label for="ambulanceNumber">Móvil (Ambulancia)</label>
                                <input type="text" id="ambulanceNumber" name="ambulanceNumber">
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label>Estado del Paciente al momento de entrega en la IPS</label>
                                <div class="checkbox-group">
                                    <div class="checkbox-item">
                                        <input type="radio" id="alive" name="patientStatus" value="VIVO">
                                        <label for="alive">VIVO</label>
                                    </div>
                                    <div class="checkbox-item">
                                        <input type="radio" id="dead" name="patientStatus" value="MUERTO">
                                        <label for="dead">MUERTO</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group" style="margin-top: 20px;">
                            <label for="additionalObservations">Observaciones</label>
                            <textarea id="additionalObservations" name="additionalObservations" rows="3"></textarea>
                        </div>
                        
                        <div class="form-row" style="margin-top: 20px;">
                            <div class="form-group">
                                <label for="repsCode">CÓDIGO REPS</label>
                                <input type="text" id="repsCode" name="repsCode">
                            </div>
                            <div class="form-group">
                                <label for="nit">NIT</label>
                                <input type="text" id="nit" name="nit" value="900432920-1" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        
        <div class="response-box" id="responseBox">
            <h3>JSON para API:</h3>
            <pre id="jsonResponse"></pre>
        </div>
        
        <div class="success" id="successMessage">
            ✅ Historia clínica enviada correctamente
        </div>
        
        <div class="navigation">
            <button type="button" class="btn-prev" id="btnPrev" onclick="previousTab()">← Anterior</button>
            <button type="button" class="btn-next" id="btnNext" onclick="nextTab()">Siguiente →</button>
            <button type="button" class="btn-submit" id="btnSubmit" onclick="submitForm()" style="display:none;">📤 Enviar</button>
            <button type="button" class="btn-pdf" id="btnPdf" onclick="generatePDF()" style="display:none;">📄 Descargar PDF</button>
        </div>
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script>
        let currentTab = 0;
        const totalTabs = 8;
        const signatures = {
            doctorSignature: null,
            patientSignature: null
        };
        
        // Setup signature canvases
        function setupSignatureCanvas(canvasId) {
            const canvas = document.getElementById(canvasId);
            const ctx = canvas.getContext('2d');
            let isDrawing = false;
            
            function getCoordinates(e) {
                const rect = canvas.getBoundingClientRect();
                const scaleX = canvas.width / rect.width;
                const scaleY = canvas.height / rect.height;
                return {
                    x: (e.clientX - rect.left) * scaleX,
                    y: (e.clientY - rect.top) * scaleY
                };
            }
            
            canvas.addEventListener('mousedown', (e) => {
                isDrawing = true;
                const coords = getCoordinates(e);
                ctx.beginPath();
                ctx.moveTo(coords.x, coords.y);
            });
            
            canvas.addEventListener('mousemove', (e) => {
                if (!isDrawing) return;
                const coords = getCoordinates(e);
                ctx.lineTo(coords.x, coords.y);
                ctx.lineWidth = 2;
                ctx.lineCap = 'round';
                ctx.lineJoin = 'round';
                ctx.stroke();
            });
            
            canvas.addEventListener('mouseup', () => {
                isDrawing = false;
            });
            
            canvas.addEventListener('mouseleave', () => {
                isDrawing = false;
            });
            
            // Soporte para touch
            canvas.addEventListener('touchstart', (e) => {
                e.preventDefault();
                isDrawing = true;
                const touch = e.touches[0];
                const mouseEvent = new MouseEvent('mousedown', {
                    clientX: touch.clientX,
                    clientY: touch.clientY
                });
                canvas.dispatchEvent(mouseEvent);
            });
            
            canvas.addEventListener('touchmove', (e) => {
                e.preventDefault();
                if (!isDrawing) return;
                const touch = e.touches[0];
                const mouseEvent = new MouseEvent('mousemove', {
                    clientX: touch.clientX,
                    clientY: touch.clientY
                });
                canvas.dispatchEvent(mouseEvent);
            });
            
            canvas.addEventListener('touchend', (e) => {
                e.preventDefault();
                isDrawing = false;
            });
        }
        
        function clearSignature(canvasId) {
            const canvas = document.getElementById(canvasId);
            const ctx = canvas.getContext('2d');
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            signatures[canvasId] = null;
            document.getElementById(canvasId + 'Preview').classList.remove('saved');
        }
        
        function saveSignature(canvasId) {
            const canvas = document.getElementById(canvasId);
            const imageData = canvas.toDataURL('image/png');
            signatures[canvasId] = imageData;
            document.getElementById(canvasId + 'Preview').src = imageData;
            document.getElementById(canvasId + 'Preview').classList.add('saved');
        }
        
        // Agregar fila a signos vitales
        function addVitalSignsRow() {
            const tableGrid = document.querySelector('.table-grid');
            const newRow = document.createElement('div');
            newRow.className = 'table-grid';
            newRow.innerHTML = `
                <div class="table-cell">
                    <input type="time" name="vitalTime[]" style="width: 100%; border: none;">
                </div>
                <div class="table-cell">
                    <input type="text" name="bloodPressure[]" placeholder="120/80" style="width: 100%; border: none;">
                </div>
                <div class="table-cell">
                    <input type="number" name="heartRate[]" style="width: 100%; border: none;">
                </div>
                <div class="table-cell">
                    <input type="number" name="respiratoryRate[]" style="width: 100%; border: none;">
                </div>
                <div class="table-cell">
                    <input type="number" name="oxygenSaturation[]" style="width: 100%; border: none;">
                </div>
                <div class="table-cell">
                    <input type="number" name="glycemia[]" style="width: 100%; border: none;">
                </div>
                <div class="table-cell">
                    <input type="number" name="temperature[]" step="0.1" style="width: 100%; border: none;">
                </div>
                <div class="table-cell">
                    <input type="number" name="glasgow[]" min="3" max="15" style="width: 100%; border: none;">
                </div>
            `;
            tableGrid.parentNode.insertBefore(newRow, tableGrid.nextSibling);
        }
        
        // Tab navigation
        function showTab(tabIndex) {
            const tabs = document.querySelectorAll('.tab-content');
            const buttons = document.querySelectorAll('.tab-button');
            
            tabs.forEach((tab, i) => {
                tab.classList.toggle('active', i === tabIndex);
            });
            
            buttons.forEach((btn, i) => {
                btn.classList.toggle('active', i === tabIndex);
            });
            
            // Update navigation buttons
            document.getElementById('btnPrev').disabled = tabIndex === 0;
            document.getElementById('btnNext').style.display = tabIndex === totalTabs - 1 ? 'none' : 'block';
            document.getElementById('btnSubmit').style.display = tabIndex === totalTabs - 1 ? 'block' : 'none';
        }
        
        function nextTab() {
            if (currentTab < totalTabs - 1) {
                currentTab++;
                showTab(currentTab);
                window.scrollTo(0, 0);
            }
        }
        
        function previousTab() {
            if (currentTab > 0) {
                currentTab--;
                showTab(currentTab);
                window.scrollTo(0, 0);
            }
        }
        
        // Calcular edad
        document.getElementById('birthDate').addEventListener('change', function() {
            const birth = new Date(this.value);
            const today = new Date();
            let age = today.getFullYear() - birth.getFullYear();
            const monthDiff = today.getMonth() - birth.getMonth();
            if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birth.getDate())) {
                age--;
            }
            document.getElementById('age').value = age;
        });
        
        // Calcular IMC
        document.getElementById('weight').addEventListener('change', calculateBMI);
        document.getElementById('height').addEventListener('change', calculateBMI);
        
        function calculateBMI() {
            const weight = parseFloat(document.getElementById('weight').value);
            const height = parseFloat(document.getElementById('height').value);
            
            if (weight && height) {
                const heightM = height / 100;
                const bmi = (weight / (heightM * heightM)).toFixed(2);
                document.getElementById('bmi').value = bmi;
            }
        }
        
        // Enviar formulario
        function submitForm() {
            const form = document.getElementById('clinicalForm');
            const formData = new FormData(form);
            
            // Recoger datos de signos vitales (array)
            const vitalTimes = formData.getAll('vitalTime[]');
            const bloodPressures = formData.getAll('bloodPressure[]');
            const heartRates = formData.getAll('heartRate[]');
            const respiratoryRates = formData.getAll('respiratoryRate[]');
            const oxygenSaturations = formData.getAll('oxygenSaturation[]');
            const glycemias = formData.getAll('glycemia[]');
            const temperatures = formData.getAll('temperature[]');
            const glasgows = formData.getAll('glasgow[]');
            
            const vitalSigns = vitalTimes.map((time, index) => ({
                hora: time,
                ta: bloodPressures[index] || '',
                fc: heartRates[index] || '',
                fr: respiratoryRates[index] || '',
                so2: oxygenSaturations[index] || '',
                glucemia: glycemias[index] || '',
                temperatura: temperatures[index] || '',
                glasgow: glasgows[index] || ''
            })).filter(vital => vital.hora || vital.ta || vital.fc);
            
            const apiData = {
                datos_paciente: {
                    nombre_completo: formData.get('fullName'),
                    tipo_documento: formData.get('documentType'),
                    numero_documento: formData.get('documentId'),
                    fecha_nacimiento: formData.get('birthDate'),
                    edad: parseInt(formData.get('age')) || 0,
                    genero: formData.get('gender'),
                    direccion: formData.get('address'),
                    ciudad: formData.get('city'),
                    telefono: formData.get('phone'),
                    correo_electronico: formData.get('email'),
                    acudiente: formData.get('patientRepresentative'),
                    eps: formData.get('eps'),
                    numero_poliza: formData.get('policyNumber'),
                    fecha_vencimiento_poliza: formData.get('policyExpiration')
                },
                consulta: {
                    fecha_consulta: formData.get('consultDate'),
                    hora_consulta: formData.get('consultTime'),
                    causa_atencion: {
                        conductor: formData.get('conductor'),
                        ocupante: formData.get('occupant'),
                        placa_vehiculo: formData.get('vehiclePlate'),
                        cinematica: formData.get('kinematics'),
                        peaton: formData.get('pedestrian'),
                        ciclista: formData.get('cyclist')
                    }
                },
                antecedentes: {
                    alergias: formData.get('allergies'),
                    cirugias_recientes: formData.get('recentSurgeries'),
                    fum: formData.get('fum'),
                    medicamentos: formData.get('currentMedications'),
                    antecedentes_enfermedades: formData.get('diseaseHistory'),
                    origen_clinico: formData.get('clinicalOrigin')
                },
                signos_vitales: {
                    registros: vitalSigns,
                    peso: parseFloat(formData.get('weight')) || 0,
                    altura: parseInt(formData.get('height')) || 0,
                    imc: parseFloat(formData.get('bmi')) || 0
                },
                examen_fisico: {
                    hallazgos: formData.get('findings')
                },
                diagnostico: {
                    clasificacion_final: formData.get('classification'),
                    tipo_traslado: formData.get('transferType'),
                    codigo_cups: formData.get('cupsCode'),
                    diagnostico_clinico: formData.get('diagnosis'),
                    observaciones: formData.get('observations')
                },
                procedimientos: {
                    inmovilizacion: formData.get('immobilization'),
                    asepsia: formData.get('asepsis'),
                    collar_cervical: formData.get('cervicalCollar'),
                    liquido: formData.get('liquids'),
                    medicamento: formData.get('medications'),
                    otros: formData.get('otherProcedures')
                },
                traslado: {
                    destino: formData.get('destination'),
                    institucion_salud: formData.get('institutionName'),
                    hora_siniestro: formData.get('accidentTime'),
                    horario_servicio: formData.get('serviceTime')
                },
                firmas_autorizaciones: {
                    declaracion_paciente: {
                        nombre: formData.get('patientSignatureName'),
                        cedula: formData.get('patientSignatureCC'),
                        firma: signatures.patientSignature
                    },
                    personal_transporte: {
                        conductor: formData.get('driverName'),
                        paramedico: formData.get('paramedicName')
                    },
                    medico_recibe: {
                        firma: signatures.doctorSignature,
                        cedula: formData.get('doctorCC'),
                        movil_ambulancia: formData.get('ambulanceNumber')
                    },
                    estado_paciente_entrega: formData.get('patientStatus'),
                    observaciones: formData.get('additionalObservations'),
                    codigo_reps: formData.get('repsCode'),
                    nit: formData.get('nit')
                },
                metadata: {
                    fecha_registro: new Date().toISOString(),
                    version_formulario: "1.0"
                }
            };
            
            document.getElementById('jsonResponse').textContent = JSON.stringify(apiData, null, 2);
            document.getElementById('responseBox').classList.add('show');
            document.getElementById('successMessage').classList.add('show');
            
            console.log('Datos listos para enviar a API:', apiData);
            
            // Mostrar botón de PDF
            document.getElementById('btnPdf').style.display = 'block';
            document.getElementById('btnSubmit').style.display = 'none';
            document.getElementById('btnNext').style.display = 'none';
            document.getElementById('btnPrev').style.display = 'none';
            
            // Descomentar para enviar a API:
            // fetch('https://tu-api.com/historia-clinica', {
            //     method: 'POST',
            //     headers: {
            //         'Content-Type': 'application/json',
            //         'Authorization': 'Bearer TU_TOKEN'
            //     },
            //     body: JSON.stringify(apiData)
            // })
            // .then(response => response.json())
            // .then(data => console.log('Respuesta del servidor:', data))
            // .catch(error => console.error('Error:', error));
        }
        
        // Click en botones de tabs
        document.querySelectorAll('.tab-button').forEach((btn, i) => {
            btn.addEventListener('click', () => {
                currentTab = i;
                showTab(currentTab);
                window.scrollTo(0, 0);
            });
        });
        
        // Generar PDF
        function generatePDF() {
            const form = document.getElementById('clinicalForm');
            const formData = new FormData(form);
            const { jsPDF } = window.jspdf;
            
            // Obtener las firmas
            const doctorSig = signatures.doctorSignature || '';
            const patientSig = signatures.patientSignature || '';
            
            // Obtener arrays de signos vitales
            const vitalTimes = formData.getAll('vitalTime[]');
            const bloodPressures = formData.getAll('bloodPressure[]');
            const heartRates = formData.getAll('heartRate[]');
            const respiratoryRates = formData.getAll('respiratoryRate[]');
            const oxygenSaturations = formData.getAll('oxygenSaturation[]');
            const glycemias = formData.getAll('glycemia[]');
            const temperatures = formData.getAll('temperature[]');
            const glasgows = formData.getAll('glasgow[]');
            
            // Crear HTML para las firmas
            let doctorSigHtml = '';
            let patientSigHtml = '';
            
            if (doctorSig) {
                doctorSigHtml = `<img src="${doctorSig}" style="max-height: 40px; max-width: 100px;">`;
            }
            if (patientSig) {
                patientSigHtml = `<img src="${patientSig}" style="max-height: 40px; max-width: 100px;">`;
            }
            
            // Crear tabla de signos vitales
            let vitalSignsTable = '';
            vitalTimes.forEach((time, index) => {
                if (time || bloodPressures[index] || heartRates[index]) {
                    vitalSignsTable += `
                        <tr>
                            <td style="border: 1px solid #000; padding: 2px; text-align: center;">${time || ''}</td>
                            <td style="border: 1px solid #000; padding: 4px; text-align: center;">${bloodPressures[index] || ''}</td>
                            <td style="border: 1px solid #000; padding: 4px; text-align: center;">${heartRates[index] || ''}</td>
                            <td style="border: 1px solid #000; padding: 4px; text-align: center;">${respiratoryRates[index] || ''}</td>
                            <td style="border: 1px solid #000; padding: 4px; text-align: center;">${oxygenSaturations[index] || ''}</td>
                            <td style="border: 1px solid #000; padding: 4px; text-align: center;">${glycemias[index] || ''}</td>
                            <td style="border: 1px solid #000; padding: 4px; text-align: center;">${temperatures[index] || ''}</td>
                            <td style="border: 1px solid #000; padding: 4px; text-align: center;">${glasgows[index] || ''}</td>
                        </tr>
                    `;
                }
            });
            
            // Si no hay registros, agregar una fila vacía
            if (vitalSignsTable === '') {
                vitalSignsTable = `
                    <tr>
                        <td style="border: 1px solid #000; padding: 8px; height: 30px;"></td>
                        <td style="border: 1px solid #000; padding: 8px;"></td>
                        <td style="border: 1px solid #000; padding: 8px;"></td>
                        <td style="border: 1px solid #000; padding: 8px;"></td>
                        <td style="border: 1px solid #000; padding: 8px;"></td>
                        <td style="border: 1px solid #000; padding: 8px;"></td>
                        <td style="border: 1px solid #000; padding: 8px;"></td>
                        <td style="border: 1px solid #000; padding: 8px;"></td>
                    </tr>
                `;
            }
            
            // Formatear fecha
            const formatDate = (dateString) => {
                if (!dateString) return '___/___/___';
                const date = new Date(dateString);
                return date.toLocaleDateString('es-CO');
            };
            
            const pdfContent = `
                <div style="font-family: Arial, sans-serif; font-size: 10px; width: 100%; padding: 10px;">
                    <!-- Encabezado -->
                    <table style="width: 100%; border-collapse: collapse; margin-bottom: 5px;">
                        <tr>
                            <td style="width: 70%; border: 1px solid #000; padding: 5px;">
                                <strong style="font-size: 9px;">ED SALUD SAS NIT 900432920-1<br>
                                CALLE 20 N. 14-52 BARRIO GAITAN CEL: 3226811175<br>
                                edsaludss@hotmail.com</strong>
                            </td>
                            <td style="width: 30%; border: 1px solid #000; padding: 5px; text-align: center;">
                                <strong>HISTORIA CLÍNICA</strong><br>
                                <strong>FECHA: ${formatDate(formData.get('consultDate'))}</strong>
                            </td>
                        </tr>
                    </table>
                    
                    <!-- Datos del Paciente -->
                    <table style="width: 100%; border-collapse: collapse; margin-bottom: 5px;">
                        <tr style="font-weight: bold; background-color: #f0f0f0;">
                            <td style="border: 1px solid #000; padding: 3px; width: 100%;">DATOS DEL PACIENTE</td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid #000; padding: 3px;">
                                <strong>Nombre:</strong> ${formData.get('fullName') || ''} &nbsp;&nbsp;&nbsp;&nbsp;
                                <strong>Tipo Doc:</strong> ${formData.get('documentType') || ''} &nbsp;&nbsp;&nbsp;&nbsp;
                                <strong>Documento:</strong> ${formData.get('documentId') || ''}
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid #000; padding: 3px;">
                                <strong>Dirección:</strong> ${formData.get('address') || ''} &nbsp;&nbsp;&nbsp;&nbsp;
                                <strong>Ciudad:</strong> ${formData.get('city') || ''} &nbsp;&nbsp;&nbsp;&nbsp;
                                <strong>Teléfono:</strong> ${formData.get('phone') || ''}
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid #000; padding: 3px;">
                                <strong>Correo:</strong> ${formData.get('email') || ''} &nbsp;&nbsp;&nbsp;&nbsp;
                                <strong>Fecha Vencimiento:</strong> ${formatDate(formData.get('policyExpiration'))} &nbsp;&nbsp;&nbsp;&nbsp;
                                <strong>Acudiente:</strong> ${formData.get('patientRepresentative') || ''}
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid #000; padding: 3px;">
                                <strong>EPS:</strong> ${formData.get('eps') || ''} &nbsp;&nbsp;&nbsp;&nbsp;
                                <strong>Nº Póliza:</strong> ${formData.get('policyNumber') || ''} &nbsp;&nbsp;&nbsp;&nbsp;
                                <strong>Edad:</strong> ${formData.get('age') || ''} &nbsp;&nbsp;&nbsp;&nbsp;
                                <strong>Género:</strong> ${formData.get('gender') || ''}
                            </td>
                        </tr>
                    </table>
                    
                    <!-- Causa que origina la atención -->
                    <table style="width: 100%; border-collapse: collapse; margin-bottom: 5px;">
                        <tr style="font-weight: bold; background-color: #f0f0f0;">
                            <td style="border: 1px solid #000; padding: 3px; width: 100%;">CAUSA QUE ORIGINA LA ATENCIÓN</td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid #000; padding: 3px;">
                                <strong>Conductor:</strong> ${formData.get('conductor') || ''} &nbsp;&nbsp;&nbsp;&nbsp;
                                <strong>Ocupante:</strong> ${formData.get('occupant') || ''} &nbsp;&nbsp;&nbsp;&nbsp;
                                <strong>Placa:</strong> ${formData.get('vehiclePlate') || ''}
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid #000; padding: 3px;">
                                <strong>Cinemática:</strong> ${formData.get('kinematics') || ''} &nbsp;&nbsp;&nbsp;&nbsp;
                                <strong>Peatón:</strong> ${formData.get('pedestrian') || ''} &nbsp;&nbsp;&nbsp;&nbsp;
                                <strong>Ciclista:</strong> ${formData.get('cyclist') || ''}
                            </td>
                        </tr>
                    </table>
                    
                    <!-- Antecedentes Personales -->
                    <table style="width: 100%; border-collapse: collapse; margin-bottom: 5px;">
                        <tr style="font-weight: bold; background-color: #f0f0f0;">
                            <td style="border: 1px solid #000; padding: 3px; width: 100%;">ANTECEDENTES PERSONALES</td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid #000; padding: 3px;">
                                <strong>Alergias:</strong> ${formData.get('allergies') || ''}
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid #000; padding: 3px;">
                                <strong>CX Recientes:</strong> ${formData.get('recentSurgeries') || ''}
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid #000; padding: 3px;">
                                <strong>F.U.M:</strong> ${formatDate(formData.get('fum'))} &nbsp;&nbsp;&nbsp;&nbsp;
                                <strong>Medicamentos:</strong> ${formData.get('currentMedications') || ''}
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid #000; padding: 3px;">
                                <strong>Antecedentes de Enfermedades:</strong> ${formData.get('diseaseHistory') || ''}
                            </td>
                        </tr>
                    </table>
                    
                    <!-- Origen Clínico -->
                    <table style="width: 100%; border-collapse: collapse; margin-bottom: 5px;">
                        <tr style="font-weight: bold; background-color: #f0f0f0;">
                            <td style="border: 1px solid #000; padding: 3px; width: 100%;">ORIGEN CLÍNICO</td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid #000; padding: 3px; height: 30px;">
                                ${formData.get('clinicalOrigin') || ''}
                            </td>
                        </tr>
                    </table>
                    
                    <!-- Signos Vitales -->
                    <table style="width: 100%; border-collapse: collapse; margin-bottom: 5px;">
                        <tr style="font-weight: bold; background-color: #f0f0f0;">
                            <td colspan="8" style="border: 1px solid #000; padding: 3px; text-align: center;">SIGNOS VITALES</td>
                        </tr>
                        <tr style="font-weight: bold;">
                            <td style="border: 1px solid #000; padding: 3px; text-align: center; width: 12%;">HORA</td>
                            <td style="border: 1px solid #000; padding: 3px; text-align: center; width: 12%;">T.A</td>
                            <td style="border: 1px solid #000; padding: 3px; text-align: center; width: 12%;">F.C</td>
                            <td style="border: 1px solid #000; padding: 3px; text-align: center; width: 12%;">F.R</td>
                            <td style="border: 1px solid #000; padding: 3px; text-align: center; width: 12%;">S.O₂</td>
                            <td style="border: 1px solid #000; padding: 3px; text-align: center; width: 12%;">GLUCEMIA</td>
                            <td style="border: 1px solid #000; padding: 3px; text-align: center; width: 12%;">TEMP</td>
                            <td style="border: 1px solid #000; padding: 3px; text-align: center; width: 16%;">GLASGOW</td>
                        </tr>
                        ${vitalSignsTable}
                        <!-- Datos adicionales -->
                        <tr>
                            <td colspan="2" style="border: 1px solid #000; padding: 3px;">
                                <strong>Peso:</strong> ${formData.get('weight') || ''} kg
                            </td>
                            <td colspan="2" style="border: 1px solid #000; padding: 3px;">
                                <strong>Altura:</strong> ${formData.get('height') || ''} cm
                            </td>
                            <td colspan="4" style="border: 1px solid #000; padding: 3px;">
                                <strong>IMC:</strong> ${formData.get('bmi') || ''}
                            </td>
                        </tr>
                    </table>
                    
                    <!-- Descripción de Hallazgos -->
                    <table style="width: 100%; border-collapse: collapse; margin-bottom: 5px;">
                        <tr style="font-weight: bold; background-color: #f0f0f0;">
                            <td style="border: 1px solid #000; padding: 3px; width: 100%;">DESCRIPCIÓN DE HALLAZGOS</td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid #000; padding: 5px; height: 80px; vertical-align: top; white-space: pre-wrap;">
                                ${formData.get('findings') || ''}
                            </td>
                        </tr>
                    </table>
                    
                    <!-- Clasificación Final -->
                    <table style="width: 100%; border-collapse: collapse; margin-bottom: 5px;">
                        <tr style="font-weight: bold; background-color: #f0f0f0;">
                            <td style="border: 1px solid #000; padding: 3px; width: 100%;">CLASIFICACIÓN FINAL</td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid #000; padding: 3px;">
                                <strong>Urgencias:</strong> ${formData.get('classification') === 'Urgencia' ? 'X' : ''} &nbsp;&nbsp;&nbsp;&nbsp;
                                <strong>Emergencias:</strong> ${formData.get('classification') === 'Emergencia' ? 'X' : ''} &nbsp;&nbsp;&nbsp;&nbsp;
                                <strong>Tipo de Traslado:</strong> ${formData.get('transferType') || ''} &nbsp;&nbsp;&nbsp;&nbsp;
                                <strong>CÓDIGO CUPS:</strong> ${formData.get('cupsCode') || ''}
                            </td>
                        </tr>
                    </table>
                    
                    <!-- Procedimientos Realizados -->
                    <table style="width: 100%; border-collapse: collapse; margin-bottom: 5px;">
                        <tr style="font-weight: bold; background-color: #f0f0f0;">
                            <td style="border: 1px solid #000; padding: 3px; width: 100%;">PROCEDIMIENTOS REALIZADOS</td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid #000; padding: 3px;">
                                <strong>Inmovilización:</strong> ${formData.get('immobilization') || ''}
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid #000; padding: 3px;">
                                <strong>Asepsia:</strong> ${formData.get('asepsis') || ''}
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid #000; padding: 3px;">
                                <strong>Collar Cervical:</strong> ${formData.get('cervicalCollar') || ''} &nbsp;&nbsp;&nbsp;&nbsp;
                                <strong>Líquido:</strong> ${formData.get('liquids') || ''}
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid #000; padding: 3px;">
                                <strong>Medicamento:</strong> ${formData.get('medications') || ''} &nbsp;&nbsp;&nbsp;&nbsp;
                                <strong>Otros:</strong> ${formData.get('otherProcedures') || ''}
                            </td>
                        </tr>
                    </table>
                    
                    <!-- Traslado -->
                    <table style="width: 100%; border-collapse: collapse; margin-bottom: 5px;">
                        <tr style="font-weight: bold; background-color: #f0f0f0;">
                            <td style="border: 1px solid #000; padding: 3px; width: 100%;">TRASLADO A</td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid #000; padding: 3px;">
                                <strong>Casa:</strong> ${formData.get('destination') === 'Casa' ? 'X' : ''} &nbsp;&nbsp;&nbsp;&nbsp;
                                <strong>Institución de Salud:</strong> ${formData.get('destination') === 'Institucion' ? 'X' : ''} &nbsp;&nbsp;&nbsp;&nbsp;
                                <strong>Nombre/Dirección:</strong> ${formData.get('institutionName') || ''}
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid #000; padding: 3px;">
                                <strong>Hora del Siniestro:</strong> ${formData.get('accidentTime') || ''} &nbsp;&nbsp;&nbsp;&nbsp;
                                <strong>Horario del Servicio:</strong> ${formData.get('serviceTime') || ''}
                            </td>
                        </tr>
                    </table>
                    
                    <!-- Diagnóstico -->
                    <table style="width: 100%; border-collapse: collapse; margin-bottom: 5px;">
                        <tr style="font-weight: bold; background-color: #f0f0f0;">
                            <td style="border: 1px solid #000; padding: 3px; width: 100%;">DIAGNÓSTICO</td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid #000; padding: 5px; height: 50px; vertical-align: top; white-space: pre-wrap;">
                                ${formData.get('diagnosis') || ''}
                            </td>
                        </tr>
                    </table>
                    
                    <!-- Observaciones -->
                    <table style="width: 100%; border-collapse: collapse; margin-bottom: 5px;">
                        <tr style="font-weight: bold; background-color: #f0f0f0;">
                            <td style="border: 1px solid #000; padding: 3px; width: 100%;">OBSERVACIONES</td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid #000; padding: 5px; height: 40px; vertical-align: top; white-space: pre-wrap;">
                                ${formData.get('observations') || ''}
                            </td>
                        </tr>
                    </table>
                    
                    <!-- Datos adicionales -->
                    <table style="width: 100%; border-collapse: collapse; margin-bottom: 5px;">
                        <tr>
                            <td style="border: 1px solid #000; padding: 3px; width: 50%;">
                                <strong>Código REPS:</strong> ${formData.get('repsCode') || ''}
                            </td>
                            <td style="border: 1px solid #000; padding: 3px; width: 50%;">
                                <strong>NIT:</strong> ${formData.get('nit') || ''}
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid #000; padding: 3px;">
                                <strong>Estado del paciente:</strong> ${formData.get('patientStatus') || ''}
                            </td>
                            <td style="border: 1px solid #000; padding: 3px;">
                                <strong>Observaciones:</strong> ${formData.get('additionalObservations') || ''}
                            </td>
                        </tr>
                    </table>
                    
                    <!-- Personal -->
                    <table style="width: 100%; border-collapse: collapse; margin-bottom: 5px;">
                        <tr>
                            <td style="border: 1px solid #000; padding: 3px; width: 50%;">
                                <strong>Conductor:</strong> ${formData.get('driverName') || ''}
                            </td>
                            <td style="border: 1px solid #000; padding: 3px; width: 50%;">
                                <strong>Paramedico:</strong> ${formData.get('paramedicName') || ''}
                            </td>
                        </tr>
                    </table>
                    
                    <!-- Firmas -->
                    <div style="page-break-before: always; margin-top: 20px;">
                        <table style="width: 100%; border-collapse: collapse; margin-bottom: 10px;">
                            <tr style="font-weight: bold; background-color: #f0f0f0;">
                                <td style="border: 1px solid #000; padding: 3px; width: 100%;">AUTORIZACIÓN DEL PACIENTE</td>
                            </tr>
                            <tr>
                                <td style="border: 1px solid #000; padding: 8px; font-style: italic;">
                                    "Declaro que en mis facultades autorizo mi traslado en el sistema de Emergencia. Me ruego a recibir la atención médica, traslado o internación sugerida por el Sistema de Emergencia Médica, eximo de toda responsabilidad a la empresa de Transporte de Urgencias Médica de las consecuencias que acarreo mi decisión, asumiendo los riesgos que mi negativa pueda generar"
                                </td>
                            </tr>
                        </table>
                        
                        <!-- Firmas -->
                        <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
                            <tr>
                                <td style="border: 1px solid #000; padding: 8px; width: 50%; text-align: center;">
                                    <div style="border-bottom: 1px solid #000; height: 60px; margin-bottom: 5px; display: flex; align-items: center; justify-content: center;">
                                        ${patientSigHtml}
                                    </div>
                                    <strong>${formData.get('patientSignatureName') || formData.get('fullName') || ''}</strong><br>
                                    <strong style="font-size: 9px;">Paciente o Familiar</strong><br>
                                    <strong style="font-size: 9px;">C.C: ${formData.get('patientSignatureCC') || formData.get('documentId') || ''}</strong>
                                </td>
                                <td style="border: 1px solid #000; padding: 8px; width: 50%; text-align: center;">
                                    <div style="border-bottom: 1px solid #000; height: 60px; margin-bottom: 5px; display: flex; align-items: center; justify-content: center;">
                                        ${doctorSigHtml}
                                    </div>
                                    <strong>${formData.get('doctorCC') ? 'Médico Tratante' : ''}</strong><br>
                                    <strong style="font-size: 9px;">Firma del Médico que Recibe</strong><br>
                                    <strong style="font-size: 9px;">C.C: ${formData.get('doctorCC') || ''}</strong>
                                </td>
                            </tr>
                        </table>
                        
                        <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
                            <tr>
                                <td style="border: 1px solid #000; padding: 5px; text-align: center;">
                                    <strong>Móvil (Ambulancia):</strong> ${formData.get('ambulanceNumber') || ''}
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            `;
            
            // Crear elemento temporal
            const element = document.createElement('div');
            element.innerHTML = pdfContent;
            element.style.position = 'absolute';
            element.style.left = '-9999px';
            element.style.width = '800px';
            element.style.backgroundColor = 'white';
            element.style.padding = '20px';
            document.body.appendChild(element);
            
            // Generar PDF después de que el contenido se renderice
            setTimeout(() => {
                html2canvas(element, { 
                    scale: 2,
                    logging: false,
                    useCORS: true,
                    backgroundColor: '#ffffff',
                    allowTaint: true,
                    onclone: function(clonedDoc) {
                        clonedDoc.querySelectorAll('input, textarea, select, button').forEach(el => {
                            el.style.display = 'none';
                        });
                    }
                }).then(canvas => {
                    const imgData = canvas.toDataURL('image/png');
                    const pdf = new jsPDF({
                        orientation: 'portrait',
                        unit: 'mm',
                        format: 'a4'
                    });
                    
                    const imgWidth = 210; // Ancho A4 en mm
                    const imgHeight = (canvas.height * imgWidth) / canvas.width;
                    
                    // Añadir la imagen al PDF
                    pdf.addImage(imgData, 'PNG', 0, 0, imgWidth, imgHeight);
                    
                    // Guardar el PDF
                    const fileName = `Historia_Clinica_${formData.get('documentId') || 'sin_documento'}_${new Date().getTime()}.pdf`;
                    pdf.save(fileName);
                    
                    // Limpiar
                    document.body.removeChild(element);
                    
                    alert(`PDF generado exitosamente: ${fileName}`);
                }).catch(err => {
                    console.error('Error generando PDF:', err);
                    document.body.removeChild(element);
                    alert('Error al generar el PDF. Por favor, verifique la consola para más detalles.');
                });
            }, 500);
        }
        
        // Inicializar
        setupSignatureCanvas('doctorSignature');
        setupSignatureCanvas('patientSignature');
        showTab(0);
    </script>
</body>
</html>