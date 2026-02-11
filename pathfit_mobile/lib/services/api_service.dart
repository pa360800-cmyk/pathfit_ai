import 'dart:convert';
import 'package:http/http.dart' as http;
import 'package:flutter_secure_storage/flutter_secure_storage.dart';

class ApiService {
  static const String baseUrl = 'http://10.0.2.2:8000'; // For Android emulator
  // static const String baseUrl = 'http://localhost:8000'; // For iOS simulator

  final _storage = const FlutterSecureStorage();

  Future<Map<String, String>> _getHeaders() async {
    final token = await _storage.read(key: 'token');
    return {
      'Content-Type': 'application/json',
      'Accept': 'application/json',
      if (token != null) 'Authorization': 'Bearer $token',
    };
  }

  Future<http.Response> _get(String endpoint) async {
    final headers = await _getHeaders();
    final response = await http.get(
      Uri.parse('$baseUrl$endpoint'),
      headers: headers,
    );
    return response;
  }

  Future<http.Response> _post(
    String endpoint,
    Map<String, dynamic> data,
  ) async {
    final headers = await _getHeaders();
    final response = await http.post(
      Uri.parse('$baseUrl$endpoint'),
      headers: headers,
      body: jsonEncode(data),
    );
    return response;
  }

  Future<http.Response> _put(String endpoint, Map<String, dynamic> data) async {
    final headers = await _getHeaders();
    final response = await http.put(
      Uri.parse('$baseUrl$endpoint'),
      headers: headers,
      body: jsonEncode(data),
    );
    return response;
  }

  // Authentication
  Future<Map<String, dynamic>> login(String email, String password) async {
    final response = await _post('/login', {
      'email': email,
      'password': password,
    });

    if (response.statusCode == 200) {
      final data = jsonDecode(response.body);
      await _storage.write(key: 'token', value: data['token']);
      return data;
    } else {
      throw Exception('Login failed');
    }
  }

  Future<Map<String, dynamic>> register(Map<String, dynamic> userData) async {
    final response = await http.post(
      Uri.parse('$baseUrl/register'),
      headers: {'Content-Type': 'application/json'},
      body: jsonEncode(userData),
    );

    if (response.statusCode == 201) {
      return jsonDecode(response.body);
    } else {
      throw Exception('Registration failed');
    }
  }

  // User Profile
  Future<Map<String, dynamic>> getUserProfile() async {
    final response = await _get('/api/user/profile');
    if (response.statusCode == 200) {
      return jsonDecode(response.body);
    } else {
      throw Exception('Failed to load profile');
    }
  }

  Future<Map<String, dynamic>> updateProfile(
    Map<String, dynamic> profileData,
  ) async {
    final response = await _put('/api/user/profile', profileData);
    if (response.statusCode == 200) {
      return jsonDecode(response.body);
    } else {
      throw Exception('Failed to update profile');
    }
  }

  // Training Sessions
  Future<List<dynamic>> getTrainingSessions() async {
    final response = await _get('/api/user/training-sessions');
    if (response.statusCode == 200) {
      return jsonDecode(response.body);
    } else {
      throw Exception('Failed to load training sessions');
    }
  }

  Future<List<dynamic>> getSessionSchedules() async {
    final response = await _get('/api/user/session-schedules');
    if (response.statusCode == 200) {
      return jsonDecode(response.body);
    } else {
      throw Exception('Failed to load session schedules');
    }
  }

  // Messages
  Future<List<dynamic>> getMessages() async {
    final response = await _get('/api/user/messages');
    if (response.statusCode == 200) {
      return jsonDecode(response.body);
    } else {
      throw Exception('Failed to load messages');
    }
  }

  Future<void> sendMessage(int recipientId, String message) async {
    final response = await _post('/api/user/messages', {
      'recipient_id': recipientId,
      'message': message,
    });

    if (response.statusCode != 200) {
      throw Exception('Failed to send message');
    }
  }

  // Activity Reports
  Future<void> submitActivityReport(Map<String, dynamic> reportData) async {
    final response = await _post('/api/user/activity-reports', reportData);
    if (response.statusCode != 201) {
      throw Exception('Failed to submit activity report');
    }
  }

  // Logout
  Future<void> logout() async {
    await _storage.delete(key: 'token');
  }

  // Check if user is logged in
  Future<bool> isLoggedIn() async {
    final token = await _storage.read(key: 'token');
    return token != null;
  }
}
