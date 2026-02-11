import 'package:flutter/material.dart';
import '../services/api_service.dart';

class AuthProvider with ChangeNotifier {
  final ApiService _apiService = ApiService();
  bool _isLoading = false;
  String? _token;
  Map<String, dynamic>? _user;

  bool get isLoading => _isLoading;
  String? get token => _token;
  Map<String, dynamic>? get user => _user;
  bool get isLoggedIn => _token != null;

  Future<bool> login(String email, String password) async {
    _isLoading = true;
    notifyListeners();

    try {
      final response = await _apiService.login(email, password);
      _token = response['token'];
      _user = response['user'];
      _isLoading = false;
      notifyListeners();
      return true;
    } catch (e) {
      _isLoading = false;
      notifyListeners();
      return false;
    }
  }

  Future<bool> register(Map<String, dynamic> userData) async {
    _isLoading = true;
    notifyListeners();

    try {
      final response = await _apiService.register(userData);
      _user = response['user'];
      _isLoading = false;
      notifyListeners();
      return true;
    } catch (e) {
      _isLoading = false;
      notifyListeners();
      return false;
    }
  }

  Future<void> logout() async {
    await _apiService.logout();
    _token = null;
    _user = null;
    notifyListeners();
  }

  Future<void> checkLoginStatus() async {
    final loggedIn = await _apiService.isLoggedIn();
    if (loggedIn) {
      // Load user data if token exists
      try {
        _user = await _apiService.getUserProfile();
      } catch (e) {
        // Token might be invalid
        await logout();
      }
    }
    notifyListeners();
  }
}
