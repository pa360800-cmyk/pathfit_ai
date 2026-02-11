import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import 'package:pathfit_mobile/providers/auth_provider.dart';
import 'package:pathfit_mobile/providers/user_provider.dart';
import 'package:pathfit_mobile/providers/training_provider.dart';
import 'package:pathfit_mobile/screens/splash_screen.dart';

void main() {
  runApp(const PathFitApp());
}

class PathFitApp extends StatelessWidget {
  const PathFitApp({super.key});

  @override
  Widget build(BuildContext context) {
    return MultiProvider(
      providers: [
        ChangeNotifierProvider(create: (_) => AuthProvider()),
        ChangeNotifierProvider(create: (_) => UserProvider()),
        ChangeNotifierProvider(create: (_) => TrainingProvider()),
      ],
      child: MaterialApp(
        title: 'PathFit Mobile',
        theme: ThemeData(
          primarySwatch: Colors.blue,
          visualDensity: VisualDensity.adaptivePlatformDensity,
          fontFamily: 'Roboto',
        ),
        home: const SplashScreen(),
        routes: {
          '/splash': (context) => const SplashScreen(),
          // Add other routes here
        },
      ),
    );
  }
}
